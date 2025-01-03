<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= $data['judul'] ?></title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?= BASEURL ?>/assets/plugins/fontawesome-free/css/all.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="<?= BASEURL ?>/assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?= BASEURL ?>/assets/dist/css/adminlte.min.css">
  <script src="https://www.google.com/recaptcha/api.js" async defer></script>

  <!-- Your code -->
</head>

<body class="hold-transition login-page">
  <div class="login-box">
    <div class="login-logo">
      <a href="#"><b>Admin</b></a>
    </div>
    <!-- /.login-logo -->
    <div class="card">
      <div class="card-body login-card-body">
        <p class="login-box-msg">Web Khusus Admin</p>

        <!-- Menampilkan flash message jika ada -->
        <?php Flasher::flash(); ?>

        <form action="<?= BASEURL ?>/Auth/login" method="post">
          <div class="input-group mb-3">
            <input type="text" class="form-control" placeholder="Username" name="username" required>
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-envelope"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
            <input type="password" class="form-control" placeholder="Password" name="password" id="password" required>
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-eye" id="togglePassword" style="cursor: pointer;"></span>
              </div>
            </div>
          </div>

          <div class="row align-items-center mb-3">
            <div class="col-auto">
              <input type="text" class="form-control form-control-sm" placeholder="Masukkan Captcha" name="captcha" style="width: 150px;">
            </div>
            <div class="col-auto">
              <img src="<?= BASEURL ?>/auth/captcha" alt="Captcha Image" style="height: 40px;">
            </div>
          </div>
          <div class="row">
            <div class="col-4">
              <button type="submit" class="btn btn-primary btn-block">Sign In</button>
            </div>
          </div>
        </form>
      </div>
      <!-- /.login-card-body -->
    </div>
  </div>

  <!-- jQuery -->
  <script src="<?= BASEURL ?>/assets/plugins/jquery/jquery.min.js"></script>
  <!-- Bootstrap 4 -->
  <script src="<?= BASEURL ?>/assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- AdminLTE App -->
  <script src="<?= BASEURL ?>/assets/dist/js/adminlte.min.js"></script>
  <script src="<?php echo BASEURL; ?>/js/password.js"></script>
</body>

</html>