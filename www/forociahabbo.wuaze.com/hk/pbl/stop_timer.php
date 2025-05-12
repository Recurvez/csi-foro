<?php
include "../../global.php"; // Archivo con la conexión a la base de datos

if (isset($_POST['username'])) {
    $username = $_POST['username'];

    $query = "
        UPDATE usuarios 
        SET total_time = 
            CASE 
                WHEN current_time IS NOT NULL 
                THEN total_time + (UNIX_TIMESTAMP() - current_time)
                ELSE total_time
            END,
            current_time = NULL, paused_until = NULL
        WHERE username = '$username' 
        AND (UNIX_TIMESTAMP() - current_time) >= 1800"; // 30 minutos

    $link->query($query);
    echo json_encode(["status" => "success"]);
}
?>
