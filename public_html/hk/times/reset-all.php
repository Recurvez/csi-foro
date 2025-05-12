<?php
include "../../global.php";
date_default_timezone_set("America/Los_Angeles");

// Reinicia a todos los usuarios sin borrar el total acumulado
$reset = "UPDATE usuarios SET 
    estado = 'inactivo',
    ini_time = NULL,
    tiempo_actual = NULL,
    tiempo_pausado = NULL,
    been_paused = 0,
    time_pause = NULL,
    paused_time = NULL,
    encargado = NULL
";

if ($link->query($reset)) {
    echo "Todos los tiempos han sido reiniciados.";
} else {
    echo "Error al reiniciar los tiempos.";
}
?>
