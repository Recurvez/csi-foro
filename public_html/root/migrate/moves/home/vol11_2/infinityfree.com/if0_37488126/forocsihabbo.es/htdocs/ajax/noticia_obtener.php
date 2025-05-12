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
$sql = "SELECT imagen, noticia, megusta, no_megusta FROM noticias WHERE id = $id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $row['noticia'] = htmlspecialchars_decode($row['noticia']); // Permitir etiquetas HTML
    echo json_encode($row);
} else {
    echo json_encode(["error" => "Noticia no encontrada"]);
}

$conn->close();
?>
