<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="description" content="Foro CSI">
    <meta name="keywords" content="Foro, CSI, Informática, Tecnología">
    <meta name="author" content="CSI">
    <meta name="robots" content="index, follow">
    <meta name="googlebot" content="index, follow">
    <title>FORO CSI</title>
    <link rel="stylesheet" href="styles.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

</head>

<body>
    <?php 
        include 'navbar.php';
        include 'inicio.php';
        include 'noticias.php';
        include 'eventos.php';
        include 'rangos.php'; 
        include 'equipo.php'; 
        include 'footer.php';
    ?>

    <!-- Modal para el Login -->
<div id="loginPopup" class="popup-container">
    <div class="popup-content">
        <span class="popup-close">&times;</span>
        <div class="popup-body" id="popup-body">
            <!-- Aquí se cargará login.php -->
        </div>
    </div>
</div>


    <script src="script.js?v=<?php echo time(); ?>"></script>
</body>

</html>