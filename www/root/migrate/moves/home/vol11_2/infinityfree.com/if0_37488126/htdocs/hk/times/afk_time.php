<?php
include "../../global.php";

$username = $_POST['username'];
$encargado = $_SESSION['username']; // Usuario que inicia el tiempo

// Obtener tiempo pausado
$query = $link->query("SELECT tiempo_pausado, UNIX_TIMESTAMP(ini_time) AS ini_time FROM usuarios WHERE username = '$username'");
$row = mysqli_fetch_array($query);
$tiempo_pausado = $row['tiempo_pausado'];
$ini_time = ($row['ini_time']) ? intval($row['ini_time']) : null;
$tiempo_transc = time() - $ini_time;

$query = "UPDATE usuarios SET tiempo_total = tiempo_total_total + 0, tiempo_pausado = NULL, tiempo_actual = NULL, encargado = NULL, estado = 'inactivo', been_paused = 0, time_pause = NULL, ini_time = NULL WHERE username = '$username'";
$link->query($query);

// Insertamos en la tabla de logs
$accion = "ha detenido el tiempo de $username por AFK";
$fecha_log_times = date('Y-m-d H:i:s');
$insertLog = "INSERT INTO log_times (usuario, accion, fecha) VALUES ('$encargado', '$accion', '$fecha_log_times')";
$link->query($insertLog);

echo "ok";
?>