<?php
require ('../global.php');

$userQuery = $link->query("SELECT ID, fondo_perfil, lupas FROM usuarios LIMIT 1");
$userData = mysqli_fetch_array($userQuery);

$userId = $userData['ID'];;
$fondoId = $_GET['id'];

// Obtener información del fondo y del usuario
$fondoQuery = $link->query("SELECT precio FROM tienda WHERE id = '$fondoId'");
$fondo = mysqli_fetch_array($fondoQuery);
$precio = $fondo['precio'];

$userQuery = $link->query("SELECT fondo_perfil, lupas FROM usuarios WHERE id = '$userId'");
$user = mysqli_fetch_array($userQuery);
$lupasDisponibles = $user['lupas'];
$fondoPerfil = $user['fondo_perfil'];

if ($fondoPerfil == $fondoId) {
    echo "Ya tienes este fondo.";
} elseif ($lupasDisponibles >= $precio) {
    // Restar lupas y actualizar el fondo del usuario
    $nuevasLupas = $lupasDisponibles - $precio;
    $link->query("UPDATE usuarios SET lupas = '$nuevasLupas', fondo_perfil = '$fondoId' WHERE id = '$userId'");
    echo "Compra realizada con éxito.";
} else {
    echo "No tienes suficientes lupas para comprar este fondo.";
}
?>
