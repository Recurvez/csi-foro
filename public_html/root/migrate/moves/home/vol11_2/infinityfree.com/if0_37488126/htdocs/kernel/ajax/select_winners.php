<?php
require ('../../global.php'); // Conectar a la base de datos

$winners = [];
$query = $link->query("SELECT username FROM usuarios WHERE rank >= 2 AND rank <= 9 AND participa_sorteo=1 ORDER BY RAND() LIMIT 3");
$prizes = ["1º Premio", "2º Premio", "3º Premio"];

$i = 0;
while ($row = mysqli_fetch_assoc($query)) {
    $winners[] = $prizes[$i] . " - " . $row['username'];
    $i++;
}

echo json_encode($winners);
?>
