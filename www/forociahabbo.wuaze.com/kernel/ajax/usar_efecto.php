<?php
require ('../../global.php');

// Obtener la ID del usuario
$userQuery = $link->query("SELECT ID FROM usuarios WHERE username = '$username'");
$userData = mysqli_fetch_array($userQuery);
$userId = $userData['ID'];

$fondoId = $_GET['id'];

// Verificar si el usuario ya tiene el fondo asignado en el perfil
$userQuery = $link->query("SELECT efecto_perfil, lupas FROM usuarios WHERE id = '$userId'");
$userData = mysqli_fetch_array($userQuery);
$fondoPerfil = $userData['efecto_perfil'];

if ($fondoPerfil == $fondoId) {
    // El usuario ya tiene el fondo asignado
    echo "Ya tienes puesto este fondo.";
} else {
    // Verificar si el usuario posee el fondo en su inventario
    $checkInventario = $link->query("SELECT * FROM inventario_fondos WHERE user_id = '$userId' AND fondo_id = '$fondoId'");
    
    if (mysqli_num_rows($checkInventario) > 0) {
        // Si tiene el fondo en su inventario, actualizar el fondo del perfil
        $link->query("UPDATE usuarios SET efecto_perfil = '$fondoId' WHERE id = '$userId'");
        echo "Fondo aplicado con éxito.";
    } else {
        // Si no tiene el fondo en el inventario, verificar si tiene lupas suficientes para comprarlo
        $fondoQuery = $link->query("SELECT precio FROM tienda WHERE id = '$fondoId'");
        $fondo = mysqli_fetch_array($fondoQuery);
        $precio = $fondo['precio'];

        $lupasDisponibles = $userData['lupas'];

        if ($lupasDisponibles >= $precio) {
            // Restar lupas y actualizar el fondo del perfil
            $nuevasLupas = $lupasDisponibles - $precio;
            $link->query("UPDATE usuarios SET lupas = '$nuevasLupas', efecto_perfil = '$fondoId' WHERE id = '$userId'");

            // Insertar la compra en el inventario de fondos
            $link->query("INSERT INTO inventario_fondos (user_id, fondo_id) VALUES ('$userId', '$fondoId')");

            echo "Compra realizada con éxito. Efecto aplicado.";
        } else {
            echo "No tienes suficientes lupas para comprar este efecto.";
        }
    }
}
?>
