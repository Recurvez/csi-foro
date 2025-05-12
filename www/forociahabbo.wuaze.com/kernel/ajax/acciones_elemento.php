<?php
require('../../global.php');

$tipo = $_GET['tipo'];
$id = $_GET['id'];
$accion = $_GET['accion'];

$userQuery = $link->query("SELECT ID, lupas FROM usuarios WHERE username = '$username'");
$userData = mysqli_fetch_array($userQuery);

$userId = $userData['ID'];
$lupasDisponibles = $userData['lupas'];

// Verificar si el elemento existe
$itemQuery = $link->query("SELECT precio FROM tienda WHERE id = '$id' AND tipo = '$tipo'");
if ($itemQuery->num_rows === 0) {
    echo "Elemento no encontrado.";
    exit;
}
$itemData = mysqli_fetch_array($itemQuery);
$precio = $itemData['precio'];

if ($accion === 'comprar') {
    $inventarioQuery = $link->query("SELECT 1 FROM inventario_fondos WHERE user_id = '$userId' AND fondo_id = '$id'");
    if ($inventarioQuery->num_rows > 0) {
        echo "Ya tienes este elemento.";
    } elseif ($lupasDisponibles >= $precio) {
        // Comprar elemento
        $link->query("INSERT INTO inventario_fondos (user_id, fondo_id) VALUES ('$userId', '$id')");
        $link->query("UPDATE usuarios SET lupas = lupas - $precio WHERE ID = '$userId'");
        echo "Compra realizada con éxito.";
    } else {
        echo "No tienes suficientes lupas.";
    }
} elseif ($accion === 'usar') {
    $inventarioQuery = $link->query("SELECT 1 FROM inventario_fondos WHERE user_id = '$userId' AND fondo_id = '$id'");
    if ($inventarioQuery->num_rows > 0) {
        $campo = $tipo === 'bg' ? 'fondo_perfil' : 'efecto_perfil';
        $link->query("UPDATE usuarios SET $campo = '$id' WHERE ID = '$userId'");
        echo "Elemento aplicado con éxito.";
    } else {
        echo "No posees este elemento.";
    }
}
?>
