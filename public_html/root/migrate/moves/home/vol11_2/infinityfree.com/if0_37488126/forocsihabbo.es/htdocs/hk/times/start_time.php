<?php
include "../../global.php";

$username = $_POST['username'];
$encargado = $_SESSION['username']; // Usuario que inicia el tiempo

// Actualizamos al usuario en la tabla usuarios
$query = "UPDATE usuarios SET tiempo_actual = NOW(), encargado = '$encargado', estado = 'activo', been_paused = 0, ini_time = NOW() WHERE username = '$username'";
$link->query($query);

// Insertamos en la tabla de logs
$accion = "ha iniciado el tiempo de $username";
$fecha_log_times = date('Y-m-d H:i:s');
$insertLog = "INSERT INTO log_times (usuario, accion, fecha) VALUES ('$encargado', '$accion', '$fecha_log_times')";
$link->query($insertLog);

echo "ok";
?>
