<?php
include "../Templates/Hk_Head.php";

// Obtener todas las semanas cerradas
$resultado = $link->query("SELECT * FROM semanas_cerradas ORDER BY fecha_cierre DESC");
?>

<div class="container">
    <h3>Historial de Semanas Cerradas</h3>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Fecha de Cierre</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_assoc($resultado)) { ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['fecha_cierre']; ?></td>
                    <td>
                        <a href="detalle_semana.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-info">Ver Detalles</a>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>
