<?php
require('../../global.php');

if (!isset($_SESSION['username'])) {
    die(json_encode(["error" => "Acceso no autorizado"]));
}

$data = $_POST;
$username = $data['username'] ?? null;
$action = $data['action'] ?? null;
$admin = $_SESSION['username'];

if (!$action || !$username) {
    die(json_encode(["error" => "Datos incompletos"]));
}

if ($action == "start") {
    $start_time = time();
    $stmt = $link->prepare("UPDATE usuarios SET encargado_pbl = ?, current_time = ?, paused_until = NULL WHERE username = ?");
    $stmt->bind_param("sis", $admin, $start_time, $username);
    $stmt->execute();
    echo json_encode(["encargado" => $admin, "current_time" => $start_time]);
}

elseif ($action == "pause") {
    $pause_until = time() + 300;
    $stmt = $link->prepare("UPDATE usuarios SET paused_until = ? WHERE username = ?");
    $stmt->bind_param("is", $pause_until, $username);
    $stmt->execute();
    echo json_encode(["paused_until" => $pause_until]);
}

elseif ($action == "resume") {
    $resume_time = time();
    $stmt = $link->prepare("UPDATE usuarios SET paused_until = NULL, current_time = ? WHERE username = ?");
    $stmt->bind_param("is", $resume_time, $username);
    $stmt->execute();
    echo json_encode(["message" => "Reanudado", "current_time" => $resume_time]);
}

elseif ($action == "stop") {
    $time = intval($data['time'] ?? 0);
    if ($time >= 1800) {
        $stmt = $link->prepare("UPDATE usuarios SET total_time = COALESCE(total_time, 0) + ?, current_time = NULL, encargado_pbl = NULL, paused_until = NULL WHERE username = ?");
        $stmt->bind_param("is", $time, $username);
        $stmt->execute();
        echo json_encode(["message" => "Tiempo guardado"]);
    } else {
        echo json_encode(["message" => "Tiempo descartado"]);
    }
}

elseif ($action == "get_status") {
    $stmt = $link->prepare("SELECT encargado_pbl, current_time, paused_until, total_time FROM usuarios WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_assoc();
    
    if ($data['current_time'] && (!$data['paused_until'] || $data['paused_until'] < time())) {
        $data['total_time'] += time() - $data['current_time'];
    }
    
    echo json_encode($data);
}
?>
