<?php
class Auth extends Controller
{
    public function index()
    {
        $data['judul'] = 'Login';
        // Tampilkan pesan flash jika ada
        $this->view('login/index', $data);
    }

    public function captcha()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Bersihkan buffer output
        ob_clean();
        ob_start();

        // Membuat teks captcha
        $captchaText = substr(str_shuffle("ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789"), 0, 6);
        $_SESSION['captcha'] = $captchaText;

        // Membuat gambar captcha
        header('Content-Type: image/png');
        $image = imagecreate(120, 40);
        $backgroundColor = imagecolorallocate($image, 255, 255, 255);
        $textColor = imagecolorallocate($image, 0, 0, 0);

        // Tambahkan teks captcha ke gambar
        imagestring($image, 5, 10, 10, $captchaText, $textColor);

        // Output gambar
        imagepng($image);
        imagedestroy($image);
        ob_end_flush();
    }

    public function login()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $username = $_POST['username'];
        $password = $_POST['password'];
        $userCaptcha = $_POST['captcha'];

        // Validasi captcha
        if ($userCaptcha !== $_SESSION['captcha']) {
            Flasher::setFlash('Captcha tidak sesuai, silahkan coba lagi.', '', 'danger');
            header("Location: " . BASEURL . "/auth/index");
            exit;
        }

        // Hapus captcha dari session untuk keamanan
        unset($_SESSION['captcha']);

        // Validasi username dan password
        $data['login'] = $this->model('Auth_model')->getUser($username, $password);

        if ($data['login'] == null) {
            Flasher::setFlash('Username atau Password salah', '', 'danger');
            header("Location: " . BASEURL . "/auth/index");
            exit;
        } else {
            foreach ($data['login'] as $row) {
                $_SESSION['nama'] = $row['nama'];
                header("Location:" . BASEURL);
                exit;
            }
        }
    }



    public function logout()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        unset($_SESSION['nama']);
        session_destroy();
        header("Location:" . BASEURL);
    }
}
