<?php
	# conectare la base de datos
	require ('../../global.php');

	$action = (isset($_REQUEST['action'])&& $_REQUEST['action'] !=NULL)?$_REQUEST['action']:'';
	if($action == 'ajax'){
		require ('../../hk/pagination.php'); //incluir el archivo de paginación
		//las variables de paginación
		$page = (isset($_REQUEST['page']) && !empty($_REQUEST['page']))?$_REQUEST['page']:1;
		$per_page = 20; //la cantidad de registros que desea mostrar
		$adjacents  = 4; //brecha entre páginas después de varios adyacentes
		$offset = ($page - 1) * $per_page;
		//Cuenta el número total de filas de la tabla*/
		$count_query   = $link->query("SELECT count(*) AS numrows FROM furnis ");
		if ($row= mysqli_fetch_array($count_query)){$numrows = $row['numrows'];}
		$total_pages = ceil($numrows/$per_page);
		$reload = 'subir.php';
		//consulta principal para recuperar los datos
		$query = $link->query("SELECT * FROM furnis  order by id DESC LIMIT $offset,$per_page");
		
		if ($numrows>0){
?>
<table class="table table-striped table-hover ">
			  <thead>
				<tr>
                              <th><?php echo $lang[312]; ?></th>
                              <th><?php echo $lang[123]; ?></th>
                              <th><?php echo $lang[120]; ?></th>
                              <th><?php echo $lang[412]; ?></th>
                              <th><?php echo $lang[413]; ?></th>
                              <th><?php echo $lang[414]; ?></th>
                             <th><?php echo $lang[140]; ?></th>
				</tr>
			</thead>
			<tbody>
			<?php
			while($row = mysqli_fetch_array($query)){

				$seccion = $row['seccion'];
		$secciones_query = $link->query("SELECT * FROM secciones_furnis WHERE tipo_n = '".$seccion."'");
		while ($seccion = mysqli_fetch_array($secciones_query)) {
			$nombre_real_seccion = $seccion['nombre'];
		}

				$icon = $row['icon'];
if("$icon"=="http://i.imgur.com/QpP3wav.png"){
  $nombre_icon = "Creditos";
}

if("$icon"=="http://i.imgur.com/hntEBNE.png"){
  $nombre_icon = "Sofa polar";
}

if("$icon"=="http://i.imgur.com/NBanQ6z.png"){
  $nombre_icon = "Vip";
}

if("$icon"=="http://i.imgur.com/6nXSdBS.png"){
  $nombre_icon = "Throne";
}

if("$icon"=="http://i.imgur.com/2sjGOmJ.png"){
  $nombre_icon = "Diamante";
}
			?>
				<tr>
                              <td><?php echo "$row[id]"; ?></td>
                              <td><?php echo "$row[nombre]"; ?></td>
                              <td><?php echo "$row[creditos]"; ?></td>
                              <td><?php echo "$row[imagen]"; ?></td>
                              <td><?php echo $nombre_real_seccion; ?></td>
                              <td><?php echo "$nombre_icon"; ?></td>
                              <td><a href="editar/furni.php?id=<?php echo "$row[id]"; ?>"><button type="button" class="btn btn-sm btn-success"><span class="MPicon-pencil"></span></button></a> <a href="eliminar/furni.php?id=<?php echo "$row[id]"; ?>"><button type="button" class="btn btn-sm btn-danger"><span class="MPicon-cross"></span></button></a></td>
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