<?php
$servername = "localhost";
$username = "forocsihabbo_wua";
$password = "makeciagreat";
$database = "forocsihabbo_wua";

$conn = new mysqli($servername, $username, $password, $database);
$conn->set_charset("utf8"); 

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

$noticiasPorPagina = 2;
$paginaActual = isset($_POST['pagina']) ? intval($_POST['pagina']) : 1;
$indiceInicio = ($paginaActual - 1) * $noticiasPorPagina;

// Obtener el total de noticias
$totalNoticiasQuery = "SELECT COUNT(*) as total FROM noticias";
$totalNoticiasResult = $conn->query($totalNoticiasQuery);
$totalNoticiasRow = $totalNoticiasResult->fetch_assoc();
$totalNoticias = $totalNoticiasRow['total'];

$totalPaginas = ceil($totalNoticias / $noticiasPorPagina);

$sql = "SELECT * FROM noticias ORDER BY fecha DESC LIMIT $indiceInicio, $noticiasPorPagina";
$result = $conn->query($sql);

$response = [
    "noticias" => "",
    "totalPaginas" => $totalPaginas
];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $response["noticias"] .= '<div class="noticia-card">
                <img src="' . $row['imagen'] . '" alt="' . $row['titulo'] . '">
                <div class="noticia-contenido">
                    <h3>' . $row['titulo'] . '</h3>
                    <p class="noticia-resumen">' . $row['resumen'] . '</p>
                    <div class="noticia-info">
                        <span class="noticia-fecha">' . date("d M Y", strtotime($row['fecha'])) . '</span>
                    </div>
                    <a href="#" class="noticia-link" data-id="' . $row['id'] . '">Leer más</a>
                </div>
            </div>';
    }
} else {
    $response["noticias"] = "<h3>No hay noticias disponibles.</h3>";
}

echo json_encode($response);
$conn->close();
?>
