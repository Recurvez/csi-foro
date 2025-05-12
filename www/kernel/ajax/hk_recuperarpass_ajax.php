<?php
require ('../../global.php');

$action = (isset($_REQUEST['action']) && $_REQUEST['action'] != NULL) ? $_REQUEST['action'] : '';
$search = (isset($_REQUEST['search']) && $_REQUEST['search'] != NULL) ? $_REQUEST['search'] : '';

if ($action == 'ajax') {
    require ('../../hk/pagination.php');
    $page = (isset($_REQUEST['page']) && !empty($_REQUEST['page'])) ? $_REQUEST['page'] : 1;
    $per_page = 10;
    $adjacents  = 4;
    $offset = ($page - 1) * $per_page;

    // Filtro de búsqueda en destinatario o asunto
    $whereClause = !empty($search) ? "WHERE destinatario LIKE '%$search%' OR asunto LIKE '%$search%'" : "";
    $count_query = $link->query("SELECT count(*) AS numrows FROM emails_pendientes $whereClause");

    if ($row = mysqli_fetch_array($count_query)) {
        $numrows = $row['numrows'];
    }

    $total_pages = ceil($numrows / $per_page);
    $reload = 'recuperarpass.php?action=ajax&search=' . urlencode($search);

    // Consulta para obtener los correos pendientes
    $query = $link->query("SELECT * FROM emails_pendientes $whereClause ORDER BY fecha DESC LIMIT $offset, $per_page");

    if ($numrows > 0) {
        ?>
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>Usuario</th>
                    <th>Destinatario</th>
                    <th>Mensaje</th>
                    <th>Fecha de Envío</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
            <?php
            while ($row = mysqli_fetch_array($query)) {
                ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['asunto']); ?></td>
                    <td><?php echo htmlspecialchars($row['destinatario']); ?></td>
                    <td><?php echo htmlspecialchars($row['mensaje']); ?></td>
                    <td><?php echo $row['fecha']; ?></td>
                    <td>
                        <a href="eliminar/recuperarpass.php?id=<?php echo $row['id']; ?>"><button type="button" class="btn btn-sm btn-danger">Eliminar</button></a>
                    </td>
                </tr>
                <?php
            }
            ?>
            </tbody>
        </table>
        <div class="table-pagination pull-right">
            <?php echo paginate($reload, $page, $total_pages, $adjacents); ?>
        </div>
        <?php
    } else {
        ?>
        <div class="alert alert-warning alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            No se encontraron resultados.
        </div>
        <?php
    }
}
?>
