<?php
include "../../global.php";

$username = $_POST['username'];
$encargado = $_SESSION['username']; // Usuario que inicia el tiempo

// Obtener el tiempo actual y el tiempo total antes de la pausa
$query = $link->query("SELECT tiempo_actual, tiempo_total FROM usuarios WHERE username = '$username'");
$row = mysqli_fetch_array($query);
$tiempo_actual = strtotime($row['tiempo_actual']);
$ini = $row['tiempo_actual'];
$tiempo_total = $row['tiempo_total'];
$diferencia_horas = 9 * 3600; // 9 horas en segundos

// Calcular el tiempo transcurrido antes de la pausa
$tiempo_pausado = $tiempo_total + ((time()-$diferencia_horas) - $tiempo_actual);

// Actualizar estado a pausado y guardar el tiempo pausado
$query = "UPDATE usuarios SET estado = 'pausado', tiempo_pausado = $tiempo_pausado, tiempo_actual = NULL, been_paused = 0, time_pause = NOW() WHERE username = '$username'";
$link->query($query);

// Insertamos en la tabla de logs
$accion = "ha pausado el tiempo de $username";
$fecha_log_times = date('Y-m-d H:i:s');
$insertLog = "INSERT INTO log_times (usuario, accion, fecha) VALUES ('$encargado', '$accion', '$fecha_log_times')";
$link->query($insertLog);

echo "ok";
?>
