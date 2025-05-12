<?php
include "../../global.php";

$username = $_POST['username'];
$encargado = $_SESSION['username']; // Usuario que reanuda

// Obtener el tiempo pausado
$query = $link->query("SELECT tiempo_pausado FROM usuarios WHERE username = '$username'");
$row = mysqli_fetch_array($query);
$tiempo_pausado = $row['tiempo_pausado'];

// Reanudar el tiempo desde donde se pausó
$query = "UPDATE usuarios SET tiempo_actual = NOW(), tiempo_total = $tiempo_pausado, estado = 'activo', encargado = '$encargado', tiempo_pausado = NULL, been_paused = 1 WHERE username = '$username'";
$link->query($query);

// Insertamos en la tabla de logs
$accion = "ha reanudado el tiempo de $username";
$fecha_log_times = date('Y-m-d H:i:s');
$insertLog = "INSERT INTO log_times (usuario, accion, fecha) VALUES ('$encargado', '$accion', '$fecha_log_times')";
$link->query($insertLog);

echo "ok";
?>
