<?php
include "../../global.php"; // Archivo con la conexión a la base de datos

if (isset($_POST['username'])) {
    $username = $_POST['username'];
    
    $query = "UPDATE usuarios SET current_time = UNIX_TIMESTAMP(), paused_until = NULL WHERE username = '$username'";
    $link->query($query);

    echo json_encode(["status" => "success"]);
}
?>
