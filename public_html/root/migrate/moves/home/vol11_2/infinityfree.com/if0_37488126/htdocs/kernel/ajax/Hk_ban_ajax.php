<?php
require ('../../global.php');

$action = (isset($_REQUEST['action']) && $_REQUEST['action'] != NULL) ? $_REQUEST['action'] : '';
$search = (isset($_REQUEST['search']) && $_REQUEST['search'] != NULL) ? $link->real_escape_string($_REQUEST['search']) : ''; // Captura y filtra el término de búsqueda

if ($action == 'ajax') {
    require ('../../hk/pagination.php'); // Incluir el archivo de paginación

    $page = (isset($_REQUEST['page']) && !empty($_REQUEST['page'])) ? $_REQUEST['page'] : 1;
    $per_page = 10; // Registros por página
    $adjacents = 4; // Brecha entre páginas
    $offset = ($page - 1) * $per_page;

    // Filtro de búsqueda si se introdujo un término
    $whereClause = !empty($search) ? "WHERE usuario LIKE '%$search%'" : "";

    $count_query = $link->query("SELECT count(*) AS numrows FROM baneo $whereClause");

    if ($row = mysqli_fetch_array($count_query)) {
        $numrows = $row['numrows'];
    }
    $total_pages = ceil($numrows / $per_page);
    $reload = 'subir.php'; // URL de recarga

    // Consulta principal para recuperar los datos
    $query = $link->query("SELECT * FROM baneo $whereClause ORDER BY id DESC LIMIT $offset, $per_page");

    if ($numrows > 0) {
        ?>
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th><?php echo 'Baneado Por'; ?></th>
                    <th><?php echo $lang[27]; ?></th>
                    <th><?php echo $lang[408]; ?></th>
                    <th><?php echo $lang[409]; ?></th>
                    <th><?php echo $lang[410]; ?></th>
                    <th><?php echo $lang[140]; ?></th>
                </tr>
            </thead>
            <tbody>
            <?php
            while ($row = mysqli_fetch_array($query)) {
                ?>
                <tr>
                    <td><?php echo $row['autor']; ?></td>
                    <td><?php echo $row['usuario']; ?></td>
                    <td><?php echo $row['razon']; ?></td>
                    <td><?php echo $row['ban_i']; ?></td>
                    <td><?php echo $row['ban_f']; ?></td>
                    <td><a href="eliminar/ban.php?id=<?php echo $row['id']; ?>"><button type="button" class="btn btn-sm btn-danger"><span class="MPicon-cross"></span></button></a></td>
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
            <?php echo $lang[195]; ?>
        </div>
        <?php
    }
}
?>
