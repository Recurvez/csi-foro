<?php
require ('../../global.php'); 

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id > 0) {
    $stmt = $link->prepare("SELECT time_pbl, pbl_total_time FROM usuarios WHERE ID = ?");
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user) {
        $totalTime = $user['pbl_total_time'];

        if ($user['time_pbl']) {
            // Calcular el tiempo transcurrido y añadir al tiempo total
            $startTime = new DateTime($user['time_pbl']);
            $now = new DateTime();
            $interval = $now->diff($startTime);
            $secondsElapsed = ($interval->days * 86400) + ($interval->h * 3600) + ($interval->i * 60) + $interval->s;
            $totalTime += $secondsElapsed;
        }

        // Actualizar la base de datos, restableciendo valores
        $stmt = $link->prepare("UPDATE usuarios SET pbl_time_on = 0, pbl_total_time = ?, pbl_paused_time = NULL, time_pbl = NULL WHERE ID = ?");
        $stmt->bind_param('ii', $totalTime, $id);
        $stmt->execute();

        // Registrar en logs
        $accion = "El usuario $username detuvo el tiempo para el usuario con ID $id. Tiempo total: $totalTime segundos.";
        $fecha_log = date('Y-m-d H:i:s');
        $stmt = $link->prepare("INSERT INTO logs (usuario, accion, fecha) VALUES (?, ?, ?)");
        $stmt->bind_param('sss', $username, $accion, $fecha_log);
        $stmt->execute();

        header("Location: ../times.php?success=tiempo_detenido");
        exit;
    }
}
?>
