<?php
require ('../../global.php');
$action = (isset($_REQUEST['action']) && $_REQUEST['action'] != NULL) ? $_REQUEST['action'] : '';
$search = (isset($_REQUEST['search']) && $_REQUEST['search'] != NULL) ? $link->real_escape_string($_REQUEST['search']) : '';

if ($action == 'ajax') {
  require ('../../hk/pagination.php'); // Incluir el archivo de paginación
  
  // Variables de paginación
  $page = (isset($_REQUEST['page']) && !empty($_REQUEST['page'])) ? $_REQUEST['page'] : 1;
  $per_page = 10; // Número de registros que deseas mostrar por página
  $adjacents = 4; // Brecha entre páginas
  $offset = ($page - 1) * $per_page;
  
  // Filtro de búsqueda
  $whereClause = !empty($search) ? "WHERE username LIKE '%$search%' AND validacion = 0" : "WHERE validacion = 0";

  // Contar el número total de filas en la tabla usuarios con el filtro aplicado
  $count_query = $link->query("SELECT count(*) AS numrows FROM usuarios $whereClause");
  if ($row = mysqli_fetch_array($count_query)) {
    $numrows = $row['numrows'];
  }
  $total_pages = ceil($numrows / $per_page);
  $reload = 'validar.php';
  
  // Consulta principal para recuperar los datos
  $query = $link->query("SELECT * FROM usuarios $whereClause ORDER BY id DESC LIMIT $offset, $per_page");

  if ($numrows > 0) {
    ?>
    <table class="table table-striped table-hover ">
      <thead>
        <tr>
          <th><?php echo $lang[27]; ?></th>
          <th>Fecha</th>
          <th>Acciones</th>
        </tr>
      </thead>
      <tbody>
      <?php
      while ($row = mysqli_fetch_array($query)) {
        ?>
        <tr>
          <td><?php echo $row['username']; ?></td>
          <td><?php echo $row['fecha']; ?></td>
          <td>
            <a href="actualizar/validar.php?id=<?php echo $row['ID']; ?>">
              <button type="button" class="btn btn-sm btn-success">
                <span class="MPicon-check"></span>
              </button>
            </a>
            <a href="eliminar/validar.php?id=<?php echo $row['ID']; ?>">
              <button type="button" class="btn btn-sm btn-danger">
                <span class="MPicon-cross"></span>
              </button>
            </a>
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
      No se encontraron usuarios pendientes de validar.
    </div>
    <?php
  }
}
?>
