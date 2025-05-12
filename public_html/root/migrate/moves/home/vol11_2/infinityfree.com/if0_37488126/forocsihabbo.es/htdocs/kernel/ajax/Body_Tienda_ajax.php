<?php 
function paginate($reload, $page, $tpages, $adjacents) {
	$prevlabel = "&lsaquo; $lang[196]";
	$nextlabel = "$lang[197] &rsaquo;";
	$out = '<ul class="pagination pagination-large">';
	
	// previous label

	if($page==1) {
		$out.= "<li class='disabled'><span><a>$prevlabel</a></span></li>";
	} else if($page==2) {
		$out.= "<li><span><a href='javascript:void(0);' onclick='load(1)'>$prevlabel</a></span></li>";
	}else {
		$out.= "<li><span><a href='javascript:void(0);' onclick='load(".($page-1).")'>$prevlabel</a></span></li>";

	}
	
	// first label
	if($page>($adjacents+1)) {
		$out.= "<li><a href='javascript:void(0);' onclick='load(1)'>1</a></li>";
	}
	// interval
	if($page>($adjacents+2)) {
		$out.= "<li><a>...</a></li>";
	}

	// pages

	$pmin = ($page>$adjacents) ? ($page-$adjacents) : 1;
	$pmax = ($page<($tpages-$adjacents)) ? ($page+$adjacents) : $tpages;
	for($i=$pmin; $i<=$pmax; $i++) {
		if($i==$page) {
			$out.= "<li class='active'><a>$i</a></li>";
		}else if($i==1) {
			$out.= "<li><a href='javascript:void(0);' onclick='load(1)'>$i</a></li>";
		}else {
			$out.= "<li><a href='javascript:void(0);' onclick='load(".$i.")'>$i</a></li>";
		}
	}

	// interval

	if($page<($tpages-$adjacents-1)) {
		$out.= "<li><a>...</a></li>";
	}

	// last

	if($page<($tpages-$adjacents)) {
		$out.= "<li><a href='javascript:void(0);' onclick='load($tpages)'>$tpages</a></li>";
	}

	// next

	if($page<$tpages) {
		$out.= "<li><span><a href='javascript:void(0);' onclick='load(".($page+1).")'>$nextlabel</a></span></li>";
	}else {
		$out.= "<li class='disabled'><span><a>$nextlabel</a></span></li>";
	}
	
	$out.= "</ul>";
	return $out;
}
?>
<?php
	require ('../../global.php');

	$action = (isset($_REQUEST['action'])&& $_REQUEST['action'] !=NULL)?$_REQUEST['action']:'';
	if($action == 'ajax'){
		//las variables de paginación
		$page = (isset($_REQUEST['page']) && !empty($_REQUEST['page']))?$_REQUEST['page']:1;
		$per_page = 6; //la cantidad de registros que desea mostrar
		$adjacents  = 4; //brecha entre páginas después de varios adyacentes
		$offset = ($page - 1) * $per_page;
		//Cuenta el número total de filas de la tabla*/
		$count_query   = $link->query("SELECT count(*) AS numrows FROM tienda ");
		if ($row= mysqli_fetch_array($count_query)){$numrows = $row['numrows'];}
		$total_pages = ceil($numrows/$per_page);
		$reload = 'tienda.php';
		//consulta principal para recuperar los datos
		$query = $link->query("SELECT * FROM tienda  order by id DESC LIMIT $offset,$per_page");
		
		if ($numrows>0){?>
<table class="table table-striped">
            <thead>
              <tr>
                <th></th>
                <th><?php echo $lang[42]; ?></th>
                <th><?php echo $lang[43]; ?></th>
                <th>Precio</th>
                <th>Unidades</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
		<?php
			while($row = mysqli_fetch_array($query)){

				$code_placa = $row['code_placa'];

				$placa_code = $link->query("SELECT * FROM placas WHERE code = '".$code_placa."'");
				while($placa = mysqli_fetch_array($placa_code)){
                $placa_img = $placa['imagen'];
				}
?>
              <tr>
              <form class="form-horizontal" action="tienda.php" method="post" enctype="multipart/form-data">
              <input type="hidden" name="id_placa" value="<?php echo $row['id']; ?>"/>
                <td></td>
                <td><img style="float:left;" src="<?php echo $placa_img; ?>" alt=""></td>
                <td><?php echo $code_placa; ?></td>
                <td><img src="<?php echo $row['icono']; ?>" alt=""><?php echo $row['precio']; ?></td>
                <td><?php echo $row['unidades']; ?></td>
                <td><button type="submit" name="guardar" class="btn btn-primary">Comprar</button></td>
                </form>
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