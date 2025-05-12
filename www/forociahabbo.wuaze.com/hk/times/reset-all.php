<?php
require ('../../global.php'); // Conectar a la base de datos

$link->query("UPDATE usuarios SET tiempo_total = 0, tiempo_pausado = NULL, tiempo_actual = NULL, encargado = NULL, estado = 'inactivo', time_pause = NULL, ini_time = NULL, been_paused = 0, tiempo_total_total = 0");
echo 'success';
?>