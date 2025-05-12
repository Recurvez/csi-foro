<?php
include "../../global.php"; // Archivo con la conexión a la base de datos

if (isset($_POST['username'])) {
    $username = $_POST['username'];

    $query = "UPDATE usuarios SET paused_until = UNIX_TIMESTAMP() + 300 WHERE username = '$username'";
    $link->query($query);

    echo json_encode(["status" => "success"]);
}
?>
