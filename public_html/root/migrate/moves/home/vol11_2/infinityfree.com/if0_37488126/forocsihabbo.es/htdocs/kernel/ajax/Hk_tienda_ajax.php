<?php

	# conectare la base de datos
require ('../../global.php');
	$action = (isset($_REQUEST['action'])&& $_REQUEST['action'] !=NULL)?$_REQUEST['action']:'';
	if($action == 'ajax'){
		require ('../../hk/pagination.php'); //incluir el archivo de paginación
		//las variables de paginación
		$page = (isset($_REQUEST['page']) && !empty($_REQUEST['page']))?$_REQUEST['page']:1;
		$per_page = 10; //la cantidad de registros que desea mostrar
		$adjacents  = 4; //brecha entre páginas después de varios adyacentes
		$offset = ($page - 1) * $per_page;
		//Cuenta el número total de filas de la tabla*/
		$count_query   = $link->query("SELECT count(*) AS numrows FROM tienda ");
		if ($row= mysqli_fetch_array($count_query)){$numrows = $row['numrows'];}
		$total_pages = ceil($numrows/$per_page);
		$reload = 'subir.php';
		//consulta principal para recuperar los datos
		$query = $link->query("SELECT * FROM tienda  order by id DESC LIMIT $offset,$per_page");
		if ($numrows>0){
			?>
<table class="table table-striped table-hover ">
			  <thead>
				<tr>
                              <th><?php echo $lang[312]; ?></th>
                              <th><?php echo $lang[43]; ?></th>
                              <th><?php echo $lang[45]; ?></th>
                              <th><?php echo $lang[44]; ?></th>
                              <th><?php echo $lang[77]; ?></th>
                              <th><?php echo $lang[42]; ?></th>
                              <th><?php echo $lang[140]; ?></th>
				</tr>
			</thead>
			<tbody>
			<?php
			while($row = mysqli_fetch_array($query)){
				$consulta = $link->query("SELECT * FROM placas WHERE code = '".$row['code_placa']."'");
				while ($placa = mysqli_fetch_array($consulta)) {
					$imagen_placa = $placa['imagen'];
				}
				?>
				<tr>
                              <td><?php echo "$row[id]"; ?></td>
                              <td><?php echo "$row[code_placa]"; ?></td>
                              <td><?php echo "$row[unidades]"; ?></td>
                              <td><?php echo "$row[precio]"; ?></td>
                              <td><?php echo "$row[icono]"; ?></td>
                              <td><img src="<?php echo $imagen_placa; ?>"></td>
                              <td><a href="editar/tienda.php?id=<?php echo "$row[id]"; ?>"><button type="button" class="btn btn-sm btn-success"><span class="MPicon-pencil"></span></button></a> <a href="eliminar/tienda.php?id=<?php echo "$row[id]"; ?>"><button type="button" class="btn btn-sm btn-danger"><span class="MPicon-cross"></span></button></a></td>
				</tr>
				<?php
			}
			?>
			</tbody>
		</table>
		<div class="table-pagination pull-right">
			<?php echo paginate($reload, $page, $total_pages, $adjacents);?>
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