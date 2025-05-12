<?php
// Conexión a la base de datos
$servername = "localhost";
$username = "forocsihabbo_for";
$password = "makeciagreat";
$database = "forocsihabbo_for";

$conn = new mysqli($servername, $username, $password, $database);
$conn->set_charset("utf8");

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

$eventosPorPagina = 1;
$paginaActual = isset($_POST['pagina']) ? intval($_POST['pagina']) : 1;
$indiceInicio = ($paginaActual - 1) * $eventosPorPagina;

// Obtener total de eventos
$totalEventosQuery = "SELECT COUNT(*) as total FROM eventos";
$totalEventosResult = $conn->query($totalEventosQuery);
$totalEventosRow = $totalEventosResult->fetch_assoc();
$totalEventos = $totalEventosRow['total'];

$totalPaginas = ceil($totalEventos / $eventosPorPagina);

$sql = "SELECT * FROM eventos ORDER BY fecha DESC LIMIT $indiceInicio, $eventosPorPagina";
$result = $conn->query($sql);

$response = [
    "eventos" => "",
    "totalPaginas" => $totalPaginas
];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $response["eventos"] .= '<div class="evento-card">
                <div class="evento-info">
                    <h3>' . $row['titulo'] . '</h3>
                    <p>' . $row['texto'] . '</p>
                    <span class="evento-fecha">' . date("d M Y", strtotime($row['fecha'])) . '</span>
                </div>
                <div class="evento-imagen">
                    <img src="' . htmlspecialchars($row['imagen']) . '" alt="Imagen del evento">
                </div>
            </div>';
    }
} else {
    $response["eventos"] = "<p>No hay eventos disponibles.</p>";
}

echo json_encode($response);
$conn->close();
?>
