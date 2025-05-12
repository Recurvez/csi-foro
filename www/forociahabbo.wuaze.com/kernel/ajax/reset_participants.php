<?php
require ('../../global.php'); // Conectar a la base de datos

$link->query("UPDATE usuarios SET participa_sorteo = 0");
echo 'success';
?>