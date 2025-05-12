<?php

require ('global.php');

include "Templates/Head.php";
include "Templates/Alertas.php";
include "Templates/Nav.php"; 
?>
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading blue">
					<h3 class="panel-title"><?php echo $lang[39]; ?></h3>
				</div>
				<div class="panel-body">
					<div class="catalogo">

										<?php 

						$resultado = $link->query("SELECT * FROM secciones_furnis WHERE id = '1'");
						while($row = mysqli_fetch_array($resultado)){
							$nombre_seccion_1 = $row['nombre'];
							$url_seccion_furnis_1 = $row['url_seccion'];
							}

						$resultado = $link->query("SELECT * FROM secciones_furnis WHERE id = '2'");
						while($row = mysqli_fetch_array($resultado)){
							$nombre_seccion_2 = $row['nombre'];
							$url_seccion_furnis_2 = $row['url_seccion'];
							}

						$resultado = $link->query("SELECT * FROM secciones_furnis WHERE id = '3'");
						while($row = mysqli_fetch_array($resultado)){
							$nombre_seccion_3 = $row['nombre'];
							$url_seccion_furnis_3 = $row['url_seccion'];
							}

						$resultado = $link->query("SELECT * FROM secciones_furnis WHERE id = '4'");
						while($row = mysqli_fetch_array($resultado)){
							$nombre_seccion_4 = $row['nombre'];
							$url_seccion_furnis_4 = $row['url_seccion'];
							}

						$resultado = $link->query("SELECT * FROM secciones_furnis WHERE id = '5'");
						while($row = mysqli_fetch_array($resultado)){
							$nombre_seccion_5 = $row['nombre'];
							$url_seccion_furnis_5 = $row['url_seccion'];
							}
					 ?>

					<div class="botones-secciones">
					<a href="<?php echo $url; ?>/furni"><button class="btn btn-primary">Todo</button></a>
						<a href="<?php echo $url; ?>/furni?<?php echo $url_seccion_furnis_1; ?>"><button class="btn btn-primary"><?php echo $nombre_seccion_1; ?></button></a>
						 <a href="<?php echo $url; ?>/furni?<?php echo $url_seccion_furnis_2; ?>"><button class="btn btn-primary"><?php echo $nombre_seccion_2; ?></button></a>
						  <a href="<?php echo $url; ?>/furni?<?php echo $url_seccion_furnis_3; ?>"><button class="btn btn-primary"><?php echo $nombre_seccion_3; ?></button></a>
						   <a href="<?php echo $url; ?>/furni?<?php echo $url_seccion_furnis_4; ?>"><button class="btn btn-primary"><?php echo $nombre_seccion_4; ?></button></a>
						    <a href="<?php echo $url; ?>/buscar-rare.php"><button class="btn btn-primary"><?php echo $lang[40]; ?></button></a>
					</div>
<center>

Buscar <input type="text" id="bus" name="bus" onkeyup="loadXMLDoc()" required />

<div id="myDiv"></div>

</center>
					</div>
				</div>
			</div>
			</div>
		</div>
	</div>

<?php
include "Templates/Footer.php"; 

?>
