<link rel="stylesheet" href="styles.css?v=<?php echo time(); ?>">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

<div class="container">
  <div class="message login">
    <div class="btn-wrapper">
      <button class="button" id="login"> Registro</button>
      <button class="button" id="signup">Inicia sesión</button>
    </div>
  </div>

  <div class="form form--login">
    <div class="form--heading">Inicio de sesión</div>
    <form autocomplete="off" method="post" action="../kernel/login/entrar.php">
      <input type="text" placeholder="Nombre de Usuario" name="username" id="username" required>
      <input type="password" placeholder="Password" name="password" id="password" required>
      <button class="button">Login</button>
    </form>
  </div>

  <div class="form form--signup">
    <div class="form--heading">Registro</div>
    <form autocomplete="off" method="post" action="../kernel/login/insertar.php">
    <input type="text" placeholder="Nombre de Usuario" name="username" id="username" required>
    <input type="email" placeholder="Correo electrónico" name="email" id="email" required>
    <input type="password" placeholder="Contraseña" name="password" id="password" required>
    <!-- Aquí se integra Google reCAPTCHA -->
    <div class="g-recaptcha" data-sitekey="6LeyxuIqAAAAAILRCzhCEsbeIVJj9VjiN26SRMBO"></div>
      <button class="button">Registro</button>
    </form>
  </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="scripts.js?v=<?php echo time(); ?>"></script>
<script src="https://www.google.com/recaptcha/api.js" async defer></script>


