<?php
require ('../../global.php');

$userQuery = $link->query("SELECT ID, efecto_perfil, lupas FROM usuarios where username = '$username'");
$userData = mysqli_fetch_array($userQuery);

$userId = $userData['ID'];
$fondoId = $_GET['id'];

// Obtener información del fondo y del usuario
$fondoQuery = $link->query("SELECT precio FROM tienda WHERE id = '$fondoId'");
$fondo = mysqli_fetch_array($fondoQuery);
$precio = $fondo['precio'];

$userQuery = $link->query("SELECT efecto_perfil, lupas FROM usuarios WHERE id = '$userId'");
$user = mysqli_fetch_array($userQuery);
$lupasDisponibles = $user['lupas'];
$fondoPerfil = $user['efecto_perfil'];

if ($fondoPerfil == $fondoId) {
    echo "Ya tienes este efecto.";
} elseif ($lupasDisponibles >= $precio) {
    // Restar lupas y actualizar el fondo del usuario
    $nuevasLupas = $lupasDisponibles - $precio;
    $link->query("UPDATE usuarios SET lupas = '$nuevasLupas', efecto_perfil = '$fondoId' WHERE id = '$userId'");
    
    // Insertar la compra en el inventario de fondos
    $link->query("INSERT INTO inventario_fondos (user_id, fondo_id) VALUES ('$userId', '$fondoId')");
    
    echo "Compra realizada con éxito.";
} else {
    echo "No tienes suficientes lupas para comprar este efecto.";
}
?>
