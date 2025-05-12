<?php
require ('../../global.php'); 

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id > 0) {
    $stmt = $link->prepare("SELECT time_pbl, pbl_total_time FROM usuarios WHERE ID = ?");
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user && $user['time_pbl']) {
        // Calcular el tiempo transcurrido desde que se inició
        $startTime = new DateTime($user['time_pbl']);
        $now = new DateTime();
        $interval = $now->diff($startTime);
        $secondsElapsed = ($interval->days * 86400) + ($interval->h * 3600) + ($interval->i * 60) + $interval->s;

        // Actualizar el tiempo total acumulado y cambiar el estado
        $totalTime = $user['pbl_total_time'] + $secondsElapsed;

        $stmt = $link->prepare("UPDATE usuarios SET pbl_time_on = 0, pbl_total_time = ?, pbl_paused_time = ?, time_pbl = NULL WHERE ID = ?");
        $pausedTime = $now->format('Y-m-d H:i:s');
        $stmt->bind_param('isi', $totalTime, $pausedTime, $id);
        $stmt->execute();

        // Registrar en logs
        $accion = "El usuario $username pausó el tiempo para el usuario con ID $id.";
        $fecha_log = date('Y-m-d H:i:s');
        $stmt = $link->prepare("INSERT INTO logs (usuario, accion, fecha) VALUES (?, ?, ?)");
        $stmt->bind_param('sss', $username, $accion, $fecha_log);
        $stmt->execute();

        header("Location: ../times.php?success=tiempo_pausado");
        exit;
    }
}
?>
