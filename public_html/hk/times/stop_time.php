<?php
include "../../global.php";
date_default_timezone_set("America/Los_Angeles");

$username = $_POST['username'] ?? null;

if (!$username) {
    echo "Error: Usuario no definido.";
    exit;
}

// Obtener tiempos del usuario
$query = "SELECT ini_time, tiempo_total_total FROM usuarios WHERE username = '$username'";
$result = $link->query($query);

if ($row = $result->fetch_assoc()) {
    $ini_time = strtotime($row['ini_time']);
    $total_anterior = (int)$row['tiempo_total_total'];

    $ahora = time();
    $transcurrido = $ahora - $ini_time;

    if ($transcurrido >= 1800) {
        $nuevo_total = $total_anterior + $transcurrido;

        $update = "UPDATE usuarios 
                   SET estado = 'inactivo', 
                       tiempo_total_total = $nuevo_total 
                   WHERE username = '$username'";
        $link->query($update);

        echo "Temporizador finalizado. Se han guardado $transcurrido segundos.";
    } else {
        // Solo marcar como inactivo
        $update = "UPDATE usuarios 
                   SET estado = 'inactivo' 
                   WHERE username = '$username'";
        $link->query($update);

        echo "Temporizador finalizado. No se ha guardado el tiempo (menos de 30 minutos).";
    }
} else {
    echo "Error: Usuario no encontrado.";
}
?>
