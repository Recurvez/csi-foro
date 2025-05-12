<?php
require ('../../global.php'); // Conectar a la base de datos

// Primero sumamos tiempo_total a tiempo_abs para todos los usuarios
$link->query("UPDATE usuarios SET tiempo_abs = tiempo_abs + tiempo_total");

// Después reiniciamos los campos
$link->query("UPDATE usuarios SET 
    tiempo_total = 0, 
    tiempo_pausado = NULL, 
    tiempo_actual = NULL, 
    encargado = NULL, 
    estado = 'inactivo', 
    time_pause = NULL, 
    ini_time = NULL, 
    been_paused = 0, 
    tiempo_total_total = 0
");

echo 'success';
?>
