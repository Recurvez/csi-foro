<?php
require('global.php');

$cartasPorPagina = 5;
$paginaActual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
$offset = ($paginaActual - 1) * $cartasPorPagina;

// Obtener el total de cartas validadas
$totalCartasQuery = $link->query("SELECT COUNT(*) as total FROM san_valentin WHERE validado = 1");
$totalCartas = $totalCartasQuery->fetch_assoc()['total'];
$totalPaginas = ceil($totalCartas / $cartasPorPagina);

// Obtener cartas con límite y paginación
$result = $link->query("SELECT mensaje FROM san_valentin WHERE validado = 1 ORDER BY id DESC LIMIT $cartasPorPagina OFFSET $offset");

$mensajes = [];
while ($row = $result->fetch_assoc()) {
    $mensajes[] = htmlspecialchars($row['mensaje']);
}

echo json_encode([
    "mensajes" => $mensajes,
    "paginaActual" => $paginaActual,
    "totalPaginas" => $totalPaginas
]);
?>
