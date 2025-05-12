<?php
include "../../global.php";
date_default_timezone_set("America/Los_Angeles");

$username = $_POST['username'] ?? null;

if (!$username) {
    echo "Error: Usuario no definido.";
    exit;
}

$update = "UPDATE usuarios 
           SET estado = 'afk' 
           WHERE username = '$username'";
$link->query($update);

echo "Usuario marcado como AFK.";
?>
