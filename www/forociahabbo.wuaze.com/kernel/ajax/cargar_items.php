<?php
require('../../global.php');

$tipo = $_GET['tipo'] ?? 'bg'; // bg para fondos, ef para efectos
$userQuery = $link->query("SELECT ID, fondo_perfil, lupas FROM usuarios WHERE username = '$username'");
$userData = mysqli_fetch_array($userQuery);

$userId = $userData['ID'];
$fondoPerfil = $userData['fondo_perfil'];
$lupasDisponibles = $userData['lupas'];

$query = $link->query("SELECT * FROM tienda WHERE tipo = '$tipo' ORDER BY id DESC");
$inventarioQuery = $link->query("SELECT fondo_id FROM inventario_fondos WHERE user_id = '$userId'");
$fondosComprados = [];
while ($fondoComprado = mysqli_fetch_array($inventarioQuery)) {
    $fondosComprados[] = $fondoComprado['fondo_id'];
}

while ($row = mysqli_fetch_array($query)) {
    $placa_img = $row['imagen'];
    $precio = $row['precio'];
    $yaPoseeFondo = in_array($row['id'], $fondosComprados);
    ?>
    <div class="fondo-card">
        <div class="fondo-header">
            <?php echo $row['code_placa']; ?>
        </div>
        <img src="<?php echo $placa_img; ?>" alt="Elemento" class="fondo-img">
        <div class="fondo-info">
            <div class="fondo-precio">
                <img src="https://images.habbo.com/c_images/album1584/DE149.png" alt="Icono" class="icono-precio">
                <?php echo $precio; ?>
            </div>
            <?php if ($yaPoseeFondo): ?>
                <button class="btn-usar" onclick="usarElemento('<?php echo $row['id']; ?>', '<?php echo $tipo; ?>')">Usar</button>
            <?php elseif ($lupasDisponibles >= $precio): ?>
                <button class="btn-comprar" onclick="comprarElemento('<?php echo $row['id']; ?>', '<?php echo $tipo; ?>')">Comprar</button>
            <?php else: ?>
                <button class="btn-sin-lupas" disabled>Insuficiente</button>
            <?php endif; ?>
        </div>
    </div>
    <?php
}
?>
