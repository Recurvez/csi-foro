<?php
include "../Templates/connection.php"; // Asegúrate de incluir la conexión a la base de datos

if (isset($_GET['search'])) {
    $query = $_GET['search'];
    $query = $link->real_escape_string($query); // Escapar caracteres especiales

    // Realizar la búsqueda en la base de datos
    $result = $link->query("SELECT username FROM usuarios WHERE username LIKE '%$query%' LIMIT 10");
    $usuarios = [];

    while ($row = mysqli_fetch_array($result)) {
        $usuarios[] = ['username' => $row['username']];
    }

    // Retornar resultados en formato JSON
    echo json_encode($usuarios);
}
?>
