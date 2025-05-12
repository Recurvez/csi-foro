<?php
include "../../global.php";

$result = $link->query("SELECT usuario, accion, fecha FROM log_times ORDER BY id DESC LIMIT 1");

if ($row = $result->fetch_assoc()) {
    echo json_encode([
        "usuario" => $row['usuario'],
        "accion" => $row['accion'],
        "fecha" => $row['fecha']
    ]);
}
?>
