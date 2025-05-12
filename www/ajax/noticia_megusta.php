<?php
// Conexión a la base de datos
$servername = "localhost";
$username = "forocsihabbo_for";
$password = "makeciagreat";
$database = "forocsihabbo_for";

$conn = new mysqli($servername, $username, $password, $database);
$conn->set_charset("utf8");

if ($conn->connect_error) {
    die(json_encode(["error" => "Error de conexión: " . $conn->connect_error]));
}

$id = isset($_POST['id']) ? intval($_POST['id']) : 0;
$tipo = isset($_POST['tipo']) ? $_POST['tipo'] : "";

if ($tipo === "megusta") {
    $sql = "UPDATE noticias SET megusta = megusta + 1 WHERE id = $id";
} elseif ($tipo === "nomegusta") {
    $sql = "UPDATE noticias SET no_megusta = no_megusta + 1 WHERE id = $id";
} else {
    echo json_encode(["error" => "Tipo no válido"]);
    exit;
}

if ($conn->query($sql) === TRUE) {
    $result = $conn->query("SELECT megusta, no_megusta FROM noticias WHERE id = $id");
    echo json_encode($result->fetch_assoc());
} else {
    echo json_encode(["error" => "Error al actualizar"]);
}

$conn->close();
?>
