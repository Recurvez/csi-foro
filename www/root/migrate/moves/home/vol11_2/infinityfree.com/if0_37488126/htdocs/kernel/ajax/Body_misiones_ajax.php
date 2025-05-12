<?php
# conectare la base de datos
require ('../../global.php');

$action = (isset($_REQUEST['action']) && $_REQUEST['action'] != NULL) ? $_REQUEST['action'] : '';
$search = (isset($_REQUEST['search']) && $_REQUEST['search'] != NULL) ? $_REQUEST['search'] : ''; // Captura el término de búsqueda

if ($action == 'ajax') {
    require ('../../hk/pagination.php'); // incluir el archivo de paginación
    // las variables de paginación
    $page = (isset($_REQUEST['page']) && !empty($_REQUEST['page'])) ? $_REQUEST['page'] : 1;
    $per_page = 10; // la cantidad de registros que desea mostrar
    $adjacents  = 4; // brecha entre páginas después de varios adyacentes
    $offset = ($page - 1) * $per_page;

    // Prepara la consulta con el filtro de búsqueda
    $whereClause = !empty($search) ? "WHERE id LIKE '%$search%' OR nombre LIKE '%$search%' OR precio LIKE '%$search%'" : "";
    $count_query   = $link->query("SELECT count(*) AS numrows FROM misiones $whereClause");
    
    if ($row = mysqli_fetch_array($count_query)) {
        $numrows = $row['numrows'];
    }

    $total_pages = ceil($numrows / $per_page);
    $reload = 'subir.php';
    
    // consulta principal para recuperar los datos
    $query = $link->query("SELECT * FROM misiones $whereClause ORDER BY num ASC LIMIT $offset, $per_page");
    
    if ($numrows > 0) {
        ?>
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th><?php echo 'Rango'; ?></th>    
                    <th><?php echo 'Misión'; ?></th>
                    <th><?php echo'Precio'; ?></th>
                </tr>
            </thead>
            <tbody>
            <?php
            while ($row = mysqli_fetch_array($query)) {

                ?>
                <tr>
                     <td><?php echo $row['id']; ?></td>
                    <td><?php echo $row['nombre']; ?></td>
                    
                    <?php if ($row['num']< 31) { ?>

                    <td><?php echo 'No a la venta'; ?></td>
                    <?php } else if ($row['num'] < 83) { ?>
                    <td><?php echo $row['precio']; ?> créditos o lupas</td>

                    <?php }else { ?>
                    <td><?php echo 'Misión administrativa'; ?></td>
                    <?php } ?>
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
