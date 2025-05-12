<?php
include "../../global.php";
date_default_timezone_set("America/Los_Angeles");

$username = $_POST['username'] ?? null;

if (!$username) {
    echo "Error: Usuario no definido.";
    exit;
}

// Verificar que exista el usuario
$query = "SELECT username FROM usuarios WHERE username = '$username'";
$result = $link->query($query);

if ($result && $result->num_rows > 0) {
    $update = "UPDATE usuarios 
               SET estado = 'reanudado', 
                   ini_time = NOW() 
               WHERE username = '$username'";
    $link->query($update);

    echo "Temporizador reanudado correctamente.";
} else {
    echo "Error: Usuario no encontrado.";
}
?>
