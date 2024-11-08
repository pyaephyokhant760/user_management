<?php
session_start();
require 'config/config.php';
if ($_POST) {
  if (empty($_POST['name']) || empty($_POST['email']) || empty($_POST['password']) || strlen($_POST['password']) < 4) {
    if (empty($_POST['name'])) {
      $nameError = 'Name Could Not Be Null';
    }
    if (empty($_POST['email'])) {
      $emailError = 'Email Could Not Be Null';
    }
    if (empty($_POST['password'])) {
      $passwordError = 'Password Could Not Be Null';
    }
    if (strlen($_POST['password']) < 4) {
      $passwordError = 'Password Should Be 4 Character at least';
    }
  } else {
    $name = $_POST['name'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $gender = $_POST['gender'];
    $address = $_POST['address'];
    $role = $_POST['role'];
    $password = password_hash($_POST['password'],PASSWORD_DEFAULT);

    $stmt = $conn->prepare("SELECT * FROM users WHERE email=:email");
    $stmt->bindValue(':email', $email);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($user) {
      echo "<script>alert('Already Email')</script>";
    } else {

      $stmt = $conn->prepare('INSERT INTO users(name,username, email, password, role,gender,phone,address,is_active) VALUES (:name, :username, :email, :password, :role, :gender,  :phone, :address, :is_active)');
      $result = $stmt->execute([
        ':name' => $name,
        ':username' => $username,
        ':email' => $email,
        ':password' => $password,
        ':role' => $role,
        ':gender' => $gender,
        ':phone' => $phone,
        ':address' => $address,
        ':is_active' =>'Pending'
      ]);

      if ($result) {
        // Registration successful
        echo "<script>alert('Register Success'); window.location.href='login.php';</script>";
      }
    }
  }
}
?>











<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Blog App | Log in</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
</head>

<body class="hold-transition login-page">
  <div class="login-box">
    <div class="login-logo">
      <a href="../../index2.html"><b>Blog</b></a>
    </div>
    <!-- /.login-logo -->
    <div class="card">
      <div class="card-body login-card-body">
        <p class="login-box-msg">Register New Account</p>

        <form action="register.php" method="post">
          <p style="color:red"><?php echo empty($nameError) ? '' : '*' . $nameError ?></p>
          <div class="input-group mb-3">
            <input type="text" name="name" class="form-control" placeholder="Name">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-user"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
            <input type="text" name="username" class="form-control" placeholder="Username">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-user"></span>
              </div>
            </div>
          </div>
          <p style="color:red"><?php echo empty($emailError) ? '' : '*' . $emailError ?></p>
          <div class="input-group mb-3">
            <input type="email" name="email" class="form-control" placeholder="Email">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-envelope"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
            <input type="number" name="phone" class="form-control" placeholder="Phone">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-envelope"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
            <input type="text" name="address" class="form-control" placeholder="Address">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-envelope"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
          <select name="gender" class="form-control">
                <option value="">Choose Gender  . . . .</option>
                <option value="male">Male</option>
                <option value="female">Female</option>
            </select>
          </div>
          <div class="input-group mb-3">
          <select name="role" class="form-control">
                <option value="">Choose Role  . . . .</option>
                <option value="1">Admin</option>
                <option value="2">User</option>
                <option value='3'>Editor</option>
            </select>
          </div>
          <p style="color:red"><?php echo empty($passwordError) ? '' : '*' . $passwordError ?></p>
          <div class="input-group mb-3">
            <input type="password" name="password" class="form-control" placeholder="Password">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
          </div>
          <div class="row">

            <!-- /.col -->
            <div class="container">
              <button type="submit" class="btn btn-primary btn-block">Register</button>
              <a href="login.php" class="btn btn-default btn btn-block">Login</a>
            </div>
            <!-- /.col -->
          </div>
        </form>
        <!-- <p class="mb-0">
        <a href="register.html" class="text-center">Register a new membership</a>
      </p> -->
      </div>
      <!-- /.login-card-body -->
    </div>
  </div>
  <!-- /.login-box -->

  <!-- jQuery -->
  <script src="plugins/jquery/jquery.min.js"></script>
  <!-- Bootstrap 4 -->
  <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- AdminLTE App -->
  <script src="dist/js/adminlte.min.js"></script>

</body>

</html>