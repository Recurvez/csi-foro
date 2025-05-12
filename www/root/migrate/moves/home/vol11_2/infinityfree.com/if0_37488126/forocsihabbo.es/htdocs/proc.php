<?php

include 'kernel/config.php';

$q = $_POST['q'];

// Preparar la consulta para evitar inyección SQL
if ($stmt = $link->prepare("SELECT * FROM usuarios WHERE username LIKE CONCAT(?, '%')")) {

    // Vincular el parámetro
    $stmt->bind_param('s', $q);

    // Ejecutar la consulta
    $stmt->execute();

    // Obtener los resultados
    $res = $stmt->get_result();

    if ($res->num_rows == 0) {
        echo '<b>No hay Resultados</b>';
    } else {
        echo '<b>Resultados:</b><br />';

        // Mostrar los resultados
        while ($fila = $res->fetch_assoc()) { ?>
            <div class="itemBox" style="background: url(<?php echo htmlspecialchars($fila['avatar']); ?>) #353333 50% no-repeat;">
            <div class="itemName">
    <a href="<?php echo $url; ?>/perfil.php?user=<?php echo $fila['username']; ?>" style="color: white;">
        <?php echo htmlspecialchars($fila['username']); ?>
    </a>
</div>

                <div class="itemPrice">
                    <div class="icon"><img src="<?php echo htmlspecialchars($fila['icon']); ?>"></div>
                    <span class="iconR"><?php echo htmlspecialchars($fila['motto']); ?></span>
                </div>
            </div>
        <?php }
    }

    // Cerrar la declaración
    $stmt->close();
}

?>
