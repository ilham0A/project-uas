<?php

class Auth extends Controller
{
    public function index()
    {
        $data['judul'] = 'Login';
        // $data['nama'] = $this->model('User_model')->getUser();
        $this->view('login/index', $data);
    }

    public function login()
    {
        $username = $_POST['username'];
        $password = $_POST['password'];
        $data['login'] = $this->model('Auth_model')->getUser($username, $password);

        session_start();
        if ($data['login'] == null) {
            header("Location: " . BASEURL . "404");
        } else {
            foreach ($data['login'] as $row):
                $_SESSION['nama'] = $row['nama'];
                header("Location:" . BASEURL);
            endforeach;
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
