<?php
include "../../global.php"; // Archivo con la conexión a la base de datos

if (isset($_POST['username'])) {
    $username = $_POST['username'];

    // Calcular cuánto tiempo estuvo en pausa
    $result = $link->query("SELECT paused_until FROM usuarios WHERE username = '$username'");
    $row = $result->fetch_assoc();
    $pausedUntil = $row['paused_until'];

    if ($pausedUntil > 0) {
        $pausedTime = time() - $pausedUntil;
        $query = "UPDATE usuarios SET current_time = UNIX_TIMESTAMP() - $pausedTime, paused_until = NULL WHERE username = '$username'";
        $link->query($query);
    }

    echo json_encode(["status" => "success"]);
}
?>
