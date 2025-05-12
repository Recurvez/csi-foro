<?php
include "global/header.php";
?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Mantenimiento</title>

  <!-- Favicon -->
  <link rel="apple-touch-icon-precomposed" sizes="144x144" href="images/ico/apple-touch-icon-144.png">
  <link rel="apple-touch-icon-precomposed" sizes="114x114" href="images/ico/apple-touch-icon-114.png">
  <link rel="apple-touch-icon-precomposed" sizes="72x72" href="images/apple-touch-icon-72.png">
  <link rel="apple-touch-icon-precomposed" href="images/ico/apple-touch-icon-57.png">
  <link rel="shortcut icon" href="images/ico/favicon.ico">
  <link rel="shortcut icon" href="images/favicon.ico">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

  <!-- Fin Favicon -->

  <!-- Responsive Design -->
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">

  <style>
    /* General Styles */
    body,
    html {
      margin: 0;
      padding: 0;
      width: 100%;
      height: 100%;
      font-family: 'Montserrat', sans-serif;
      background: url('http://i.imgur.com/sLm8lYi.png') no-repeat center center fixed;
      background-size: cover;
      color: #fff;
    }

    /* Centering Containers */
    .center-container {
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      text-align: center;
      padding: 20px;
      background-color: rgba(0, 0, 0, 0.6);
    }

    /* Mantenimiento Section */
    .error {
      max-width: 600px;
      background: rgba(255, 255, 255, 0.1);
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
    }

    .error h1 {
      font-size: 50px;
      margin-bottom: 10px;
    }

    .error p {
      font-size: 18px;
      font-weight: bold;
      margin-bottom: 20px;
    }

    .error a {
      color: #beff00;
      text-decoration: none;
      font-weight: bold;
    }

    .error a:hover {
      text-decoration: underline;
    }

    /* Login Panel Styles */
    .login-panel {
      background: rgba(255, 255, 255, 0.1);
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
      width: 100%;
      max-width: 400px;
    }

    .login-header {
      text-align: center;
      margin-bottom: 20px;
    }

    .login-title {
      font-size: 24px;
      font-weight: bold;
      color: #beff00;
    }

    .badge-container {
      width: 50px;
      height: 50px;
      background-repeat: no-repeat;
      background-size: contain;
      margin: 0 auto 10px;
    }

    .login-form {
      display: flex;
      flex-direction: column;
      gap: 15px;
    }

    .login-form label {
      font-size: 14px;
      text-align: left;
    }

    .input-group {
      display: flex;
      align-items: center;
      border-radius: 5px;
      overflow: hidden;
      background-color: #f2f2f2;
      /* Fondo del contenedor del input */
    }

    .input-icon {
      padding: 10px;
      background: #333;
      color: #fff;
    }

    input[type="text"],
    input[type="password"] {
      flex: 1;
      padding: 10px;
      border: none;
      background-color: #fff;
      color: #000;
    }


    input::placeholder {
      color: #777;
      /* Color de los placeholders */
    }


    input::placeholder {
      color: #aaa;
    }

    .forgot-password {
      text-align: right;
      font-size: 12px;
      color: #beff00;
      text-decoration: none;
    }

    .forgot-password:hover {
      text-decoration: underline;
    }

    .login-button {
      padding: 10px;
      background: #beff00;
      color: #000;
      font-weight: bold;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      transition: background 0.3s;
    }

    .login-button:hover {
      background: #9a5c32;
      color: #fff;
    }
  </style>
</head>

<body>

  <!-- Mantenimiento Section -->
  <div class="center-container">
    <div class="error">
      <h1>Mantenimiento</h1>
      <p>Estamos actualizando y mejorando la experiencia en nuestra web.<br>Estaremos de vuelta muy pronto.</p>
      <a href="<?php echo 'https://x.com/HabboesCIA'; ?>">Ver Twitter oficial</a>
    </div>
  </div>

  <!-- Login Section -->
  <div class="center-container">
    <div class="login-panel">
      <div class="login-header">
        <h3 class="login-title">
          <div class="badge-container"
            style="background-image:url('https://images.habbo.com/c_images/album1584/PTB32.png');"></div>
          <?php echo 'Inicio de sesión'; ?>
        </h3>
      </div>
      <form class="login-form" method="post" action="kernel/login/entrar2.php">
        <label for="username"><?php echo $lang[27]; ?></label>
        <div class="input-group">
          <span class="input-icon"><i class="glyphicon glyphicon-user"></i></span>
          <input type="text" id="username" name="username" required placeholder="<?php echo 'Nombre de usuario'; ?>">
        </div>

        <label for="password"><?php echo $lang[28]; ?></label>
        <div class="input-group">
          <span class="input-icon"><i class="glyphicon glyphicon-lock"></i></span>
          <input type="password" id="password" name="password" required placeholder="<?php echo 'Contraseña'; ?>">
        </div>

        <button type="submit" class="login-button"><?php echo 'Iniciar Sesión'; ?></button>
      </form>
    </div>
  </div>

</body>

</html>