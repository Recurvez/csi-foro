<?php
require ('../../global.php'); 

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

if ($id > 0) {
    $encargado_pbl = $username;
    $start_time = date('Y-m-d H:i:s');

    // Verificar si el usuario ya tiene un tiempo en curso
    $stmt = $link->prepare("SELECT pbl_time_on FROM usuarios WHERE ID = ?");
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user['pbl_time_on'] == 1) {
        // Si el tiempo ya está en curso, redirigir con mensaje de error
        header("Location: ../times.php?error=tiempo_ya_en_curso");
        exit;
    }

    // Iniciar el tiempo para el usuario
    $stmt = $link->prepare("UPDATE usuarios SET pbl_time_on = 1, encargado_pbl = ?, time_pbl = ?, pbl_paused = 0 WHERE ID = ?");
    $stmt->bind_param('ssi', $encargado_pbl, $start_time, $id);
    $stmt->execute();

    // Registrar en logs
    $accion = "El usuario $encargado_pbl ha creado el tiempo para el usuario con ID $id.";
    $fecha_log = date('Y-m-d H:i:s');
    $stmt = $link->prepare("INSERT INTO logs (usuario, accion, fecha) VALUES (?, ?, ?)");
    $stmt->bind_param('sss', $encargado_pbl, $accion, $fecha_log);
    $stmt->execute();

    // Redirigir con éxito
    header("Location: ../times.php?success=tiempo_creado");
    exit;
}
?>
