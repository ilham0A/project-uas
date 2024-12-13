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

        // Memanggil model untuk mendapatkan data user berdasarkan username
        $data['login'] = $this->model('Auth_model')->getUser($username, $password);

        session_start();
        if ($data['login'] == null) {
            // Set flash message untuk kesalahan login
            Flasher::setFlash('Username atau Password salah', '', 'danger');
            header("Location: " . BASEURL . "/auth/index");
            exit;
        } else {
            // Jika login berhasil
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
