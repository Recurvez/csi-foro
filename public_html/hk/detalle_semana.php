<?php
include "../Templates/Hk_Head.php";

$id = intval($_GET['id']);
$resultado = $link->query("SELECT * FROM semanas_cerradas WHERE id = $id");
$semana = $resultado->fetch_assoc();

$datos = json_decode($semana['datos'], true);
?>

<div class="container">
    <h3>Detalles de la Semana Cerrada</h3>
    <p><strong>Fecha de Cierre:</strong> <?php echo $semana['fecha_cierre']; ?></p>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Usuario</th>
                <th>Minutos</th>
                <th>Pagado</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($datos as $paga) { ?>
                <tr>
                    <td><?php echo $paga['id']; ?></td>
                    <td><?php echo $paga['usuario']; ?></td>
                    <td><?php echo $paga['mins']; ?></td>
                    <td><?php echo $paga['pagado'] == 1 ? 'Sí' : 'No'; ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>
