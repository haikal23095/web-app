<?php
session_start();

include_once($_SERVER["DOCUMENT_ROOT"] . "/config.php");
include_once(BASEPATH . "/database.php");
include_once(BASEPATH . "/functions.php");

$errors = [];
if ($_SERVER["REQUEST_METHOD"] == "POST"){
    checklogin($_POST, $errors);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>SIAKAD Universitas Trunojoyo Madura</title>
  <link rel="stylesheet" href="./css/style-landing-page.css">
</head>
<body>
  <header>
    <div class="logo">
      <img src="assets/img/logo_utm.png" alt="logo-utm" id="logo-utm"">
      <h1>SIAKAD</h1>
    </div>
    <div class="nav">
      <a href="#login-form"><button class="nav-btn">Login</button></a>
      <a href="#logo-utm"><button class="nav-btn">Home</button></a>
    </div>
  </header>
  <main>
    <section class="hero">
      <div class="hero-text">
        <h2>Sistem Informasi Akademik Universitas Trunojoyo Madura</h2>
        <a href="#login-form" class="btn-primary">Login</a>
      </div>
      <div class="hero-image">
        <img src="./assets/img/student_image_landing_page.png" alt="Graduation illustration">
      </div>
    </section>
    <section class="login-section" id="login-form">
      <form class="login-form" method="POST">
        <h3>Form Login Civitas Academica</h3>
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <div class="alert">
        <?php
        if (!empty($errors)) {
          foreach ($errors as $error) {
            echo $error . "<br>";
          }
        }
        ?>
        </div>
        
        <button type="submit" class="btn-primary">Login</button>
        <p>Bagi civitas yang lupa ID atau password silakan hubungi bagian registrasi UTM.</p>
      </form>
      <div class="form-illustration">
        <img src="./assets/img/hero-image_landing_page.png" alt="Form illustration">
      </div>
    </section>
  </main>
  <script src="./js/script.js"></script>
</body>
</html>
