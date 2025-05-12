<?php
require ('../../global.php'); 

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id > 0) {
    $now = date('Y-m-d H:i:s');

    $stmt = $link->prepare("UPDATE usuarios SET pbl_time_on = 1, time_pbl = ? WHERE ID = ?");
    $stmt->bind_param('si', $now, $id);
    $stmt->execute();

    // Registrar en logs
    $accion = "El usuario $username reanudó el tiempo para el usuario con ID $id.";
    $fecha_log = date('Y-m-d H:i:s');
    $stmt = $link->prepare("INSERT INTO logs (usuario, accion, fecha) VALUES (?, ?, ?)");
    $stmt->bind_param('sss', $username, $accion, $fecha_log);
    $stmt->execute();

    header("Location: ../times.php?success=tiempo_reanudado");
    exit;
}
?>
