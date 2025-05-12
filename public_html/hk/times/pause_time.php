<?php
include "../../global.php";
date_default_timezone_set("America/Los_Angeles");

$username = $_POST['username'] ?? null;

if (!$username) {
    echo "Error: Usuario no definido.";
    exit;
}

// Obtener el tiempo de inicio y el tiempo restante previo
$query = "SELECT ini_time, tiempo_pausado FROM usuarios WHERE username = '$username'";
$result = $link->query($query);

if ($row = $result->fetch_assoc()) {
    $ini_time = strtotime($row['ini_time']);
    $tiempo_pausado = (int)$row['tiempo_pausado'];

    $ahora = time();
    $transcurrido = $ahora - $ini_time;
    $nuevo_restante = max(0, $tiempo_pausado - $transcurrido);

    $update = "UPDATE usuarios 
               SET estado = 'pausado', 
                   tiempo_pausado = $nuevo_restante, 
                   time_pause = NOW(), 
                   been_paused = 1 
               WHERE username = '$username'";
    $link->query($update);

    echo "Temporizador pausado. Tiempo restante guardado: $nuevo_restante segundos.";
} else {
    echo "Error: Usuario no encontrado.";
}
?>
