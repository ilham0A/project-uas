<?php

class Auth extends Controller
{
    public function index()
    {
        $data['judul'] = 'Login';
        // Tampilkan pesan flash jika ada
        $this->view('login/index', $data);
    }

    public function login()
    {
        $username = $_POST['username'];
        $password = $_POST['password'];

        // Validasi reCAPTCHA
        $recaptchaResponse = $_POST['g-recaptcha-response'];
        $secretKey = "6Ldd5qMqAAAAAJNfCnH1DJjUH3bfdL55_4jH_8ve"; // Ganti dengan Secret Key dari Google
        $recaptchaUrl = "https://www.google.com/recaptcha/api/siteverify";

        // Kirim request ke Google untuk verifikasi
        $response = file_get_contents($recaptchaUrl . "?secret=" . $secretKey . "&response=" . $recaptchaResponse);
        $responseKeys = json_decode($response, true);

        if (!$responseKeys['success']) {
            // Jika reCAPTCHA gagal
            Flasher::setFlash('Validasi reCAPTCHA gagal, silahkan coba lagi.', '', 'danger');
            header("Location: " . BASEURL . "/auth/index");
            exit;
        }

        // Validasi username dan password
        $data['login'] = $this->model('Auth_model')->getUser($username, $password);

        session_start();
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
        session_start();
        unset($_SESSION['nama']);
        session_destroy();
        header("Location:" . BASEURL);
    }
}
