<?php
include "../../global.php";

// Seguridad: reportar solo errores fatales
error_reporting(E_ERROR);
ini_set('display_errors', 0);

// Asegúrate de que siempre se devuelve un JSON válido aunque haya error
header('Content-Type: application/json');

$data = [];

// Verificar si la consulta se ejecuta correctamente
if ($result = $link->query("SELECT username, been_paused, tiempo_total, UNIX_TIMESTAMP(tiempo_actual) AS tiempo_actual, UNIX_TIMESTAMP(time_pause) AS time_pause, UNIX_TIMESTAMP(ini_time) AS ini_time, estado, encargado FROM usuarios WHERE rank >= 2 AND rank <= 9 ORDER BY username ASC")) {

    while ($row = $result->fetch_assoc()) {
        $username = $row['username'];
        $estado = $row['estado'];
        $encargado = $row['encargado'] ?: '-';
        $been_paused = $row['been_paused'];
        $segundos = $row['tiempo_total'];
        $horas = floor($segundos / 3600);
        $minutos = floor(($segundos % 3600) / 60);
        $segundos_restantes = $segundos % 60;

        $tiempo_total = str_pad($horas, 2, "0", STR_PAD_LEFT) . ":" .
            str_pad($minutos, 2, "0", STR_PAD_LEFT) . ":" .
            str_pad($segundos_restantes, 2, "0", STR_PAD_LEFT);

        $time_pause = $row['time_pause'] ?? 0;
        $tiempo_actual = $row['tiempo_actual'] ?? 0;
        $ini_time = $row['ini_time'] ?? 0;

        $timerHtml = "";
        $acciones = "";

        if ($estado === 'activo') {
            if ($been_paused == 1) {
                $start_time = $ini_time + ($tiempo_actual - $time_pause);
                $elapsed = time() - $start_time;
                $h = str_pad(floor($elapsed / 3600), 2, '0', STR_PAD_LEFT);
                $m = str_pad(floor(($elapsed % 3600) / 60), 2, '0', STR_PAD_LEFT);
                $s = str_pad($elapsed % 60, 2, '0', STR_PAD_LEFT);
                $elapsed_formatted = "$h:$m:$s";

                $timerHtml = "<span class='timer' data-start-time='{$start_time}' data-username='{$username}'>{$elapsed_formatted}</span>";
                $acciones = "<button class='btn btn-danger btn-sm stop-time' data-username='{$username}'>Detener</button>";
            } else {
                $start_time = $tiempo_actual;
                $elapsed = time() - $start_time;
                $h = str_pad(floor($elapsed / 3600), 2, '0', STR_PAD_LEFT);
                $m = str_pad(floor(($elapsed % 3600) / 60), 2, '0', STR_PAD_LEFT);
                $s = str_pad($elapsed % 60, 2, '0', STR_PAD_LEFT);
                $elapsed_formatted = "$h:$m:$s";

                $timerHtml = "<span class='timer' data-start-time='{$start_time}' data-username='{$username}'>{$elapsed_formatted}</span>";

                $acciones = "<button class='btn btn-warning btn-sm pause-time' data-username='{$username}'>Pausar</button> ";
                $acciones .= "<button class='btn btn-danger btn-sm stop-time' data-username='{$username}'>Detener</button>";
                $acciones .= " <button class='btn btn-info btn-sm afk-time' data-username='{$username}'>AFK</button>";
            }
        } elseif ($estado === 'pausado') {
            $tiempo_restante = max(0, 300 - (time() - $time_pause));
            $timerHtml = "<span class='timer-descendente' data-tiempo-restante='{$tiempo_restante}' data-username='{$username}'></span>";
            $acciones = "<button class='btn btn-success btn-sm resume-time' data-username='{$username}'>Reanudar</button>";
        } else {
            $timerHtml = $tiempo_total;
            $acciones = "<button class='btn btn-success btn-sm start-time' data-username='{$username}'>Iniciar</button>";
        }

        $data[] = [
            htmlspecialchars($username),
            $timerHtml,
            htmlspecialchars($encargado),
            $acciones
        ];
    }
} else {
    // Si la consulta falla, opcionalmente puedes loguearlo:
    // error_log("Error en la consulta SQL: " . $link->error);
}

echo json_encode(["data" => $data]);
