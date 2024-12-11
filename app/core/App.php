<?php
class App
{
    protected $controller = 'Home'; //controller default
    protected $method = 'index'; //method default
    protected $params = []; //parameter default

    public function __construct()
    {
        $url = $this->parseURL();


        // Jika $url kosong, set $url ke array dengan controller default
        if ($url == null) {
            $url = [$this->controller];
        }

        //controller
        if (file_exists('../app/controllers/' . $url[0] . '.php')) {
            //cek dulu apakah ada file di dalam folder controllers

            $this->controller = $url[0];
            unset($url[0]); //hapus elemen array ke1
        }

        require_once '../app/controllers/' . $this->controller . '.php';
        $this->controller = new $this->controller; //membuat objek baru sesuai controller

        //method
        if (isset($url[1])) {
            if (method_exists($this->controller, $url[1])) {
                //cek apakah ada method $url[1] didalam $this->controller

                $this->method = $url[1];
                unset($url[1]); //hapus elemen aray ke2
            }
        }

        //params
        if (!empty($url)) {
            $this->params = array_values($url);
        }

        //jalankan controller & method, serta kirimkan params jika ada
        call_user_func_array([$this->controller, $this->method], $this->params);
    }

    public function parseURL()
    // memecah URL 
    //contoh: /home/show/1 => ['home','show','1'], ket: [controller,method,parameter]
    {
        if (isset($_GET['url'])) {
            $url = rtrim($_GET['url'], '/'); //menghapus tanda / di akhir URL
            $url = filter_var($url, FILTER_SANITIZE_URL); //membersihkan url dari karakter aneh
            $url = explode('/', $url); // memecah URL menjadi array berdasarkan tanda /
            return $url;
        }
    }
}

// Alur Eksekusi Kode

// Ketika sebuah URL diberikan, misalnya /home/show/1:
// Fungsi parseURL() memecah URL menjadi array: ['home', 'show', '1'] -> [controllers, method, parameter]
// Program mengecek apakah ada file controller home.php. Jika ada, program memuat file tersebut dan membuat objek dari controller Home.
// Program mengecek apakah ada method show di controller Home. Jika ada, method tersebut di-set sebagai method yang akan dipanggil.
// Parameter yang tersisa (1) akan disimpan dalam $params.
// Program memanggil method show di controller Home, dan mengirimkan parameter 1 ke method tersebut.