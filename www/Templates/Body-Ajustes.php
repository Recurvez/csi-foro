<div class="container">
<?php 
if($_SESSION["logeado"] != "SI"){
header ("Location: ../index");
}
?>
     <div class="row">
        <div class="col-md-8">
			<?php if(isset($_GET['regalos'])){?>

            
								<div class="panel panel-default">
							<div class="panel-heading blue">
						<h3 class="panel-title"><?php echo $lang[136]; ?></h3>
					</div>
				<div class="panel-body">
				
				<?php 
$mensajes_recibidos = $link->query("SELECT * FROM usuarios_regalos WHERE user_recibido = '".$username."'");
$mensajes_recibidos_r = mysqli_num_rows($mensajes_recibidos);
			if("$mensajes_recibidos_r" == "0"){
					echo "<div class='alert alerta-no alert-dismissible'><button type='button' class='close' data-dismiss='alert'>×</button>$lang[141]</div>";
			} else {
				?>
<table class="table table-striped">
            <thead>
              <tr>
                <th><?php echo $lang[137]; ?></th>
                <th><?php echo $lang[138]; ?></th>
				<th><?php echo $lang[139]; ?></th>
				<th><?php echo $lang[140]; ?></th>
              </tr>
            </thead>
            <tbody>
						<?php 
						$resultado = $link->query("SELECT * FROM usuarios_regalos WHERE user_recibido = '".$username."' ORDER BY id DESC");
						while($row = mysqli_fetch_array($resultado)){
							$user_recibido = $row['user_recibido'];
							$user_enviado = $row['user_enviado'];
							$asunto_regalo = $row['asunto_regalo'];
							$mensaje_regalo = $row['mensaje_regalo'];
							$regalo = $row['code_placa'];
							$id_regalo = md5($row['id']);
							?>
              <tr>
			    <td><?php echo $user_enviado; ?></button>
                <td><?php echo $asunto_regalo; ?></td>
				<td><?php echo $lang[143]; ?>: <?php echo $regalo; ?></button>
                <td><button data-toggle="modal" data-target="#enviar_mensaje" class='btn btn-xs btn-default'><?php echo $lang[144]; ?></button> <button data-toggle="modal" data-target="#ver_regalo_<?php echo $id_regalo; ?>" class='btn btn-xs btn-default'><?php echo $lang[142]; ?></button></td>
              </tr>
			  
			      <!-- Modal -->
  <div class="modal fade" id="ver_regalo_<?php echo $id_regalo; ?>" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title"><?php echo $lang[145]; ?> <a href="<?php echo $url; ?>/perfil.php?user=<?php echo $user_enviado; ?>"><?php echo $user_enviado; ?></a></h4>
        </div>
        <div class="modal-body">
		  
<form class="form-horizontal" action="ajustes.php?regalos" method="post" enctype="multipart/form-data">
  <fieldset>
    <div class="form-group">
      <label for="inputEmail" class="col-lg-2 control-label"><?php echo $lang[96]; ?>:</label>
      <div class="col-lg-10">
        <?php echo $asunto_regalo; ?>
      </div>
    </div>
<br>
    <div class="form-group">
      <label for="textArea" class="col-lg-2 control-label"><?php echo $lang[97]; ?>:</label>
      <div class="col-lg-10">
        <?php echo $mensaje_regalo; ?>
        
      </div>
    </div>
<br>
    <div class="form-group">
      <label for="inputEmail" class="col-lg-2 control-label"><?php echo $lang[139]; ?>:</label>
      <div class="col-lg-10">
        Placa: <?php echo $regalo; ?> 
								<?php 
						$placa1=$link->query("SELECT * FROM placas WHERE code = '".$regalo."'");
						while($row = mysqli_fetch_array($placa1)){
							$imagen_placa = $row['imagen']; ?>
						<img src="<?php echo $imagen_placa; ?>">
						<?php } ?>
      </div>
    </div>
  </fieldset>
</form>
		  
        </div>
      </div>
      
    </div>
  </div>
			  
			  <!-- Modal -->
  <div class="modal fade" id="enviar_mensaje" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title"><?php echo $lang[95]; ?> <a href="<?php echo $url; ?>/perfil.php?user=<?php echo $user_enviado; ?>"><?php echo $user_enviado; ?></a></h4>
        </div>
        <div class="modal-body">
		  
<form class="form-horizontal" action="ajustes.php?regalos" method="post" enctype="multipart/form-data">
  <fieldset>
    <div class="form-group">
      <label for="inputEmail" class="col-lg-2 control-label"><?php echo $lang[96]; ?></label>
      <div class="col-lg-10">
        <input type="text" class="form-control" name="asunto" value="Respuesta: <?php echo $asunto_regalo; ?>" placeholder="Usuario Reportado">
      </div>
    </div>
´<br>
    <div class="form-group">
      <label for="textArea" class="col-lg-2 control-label"><?php echo $lang[97]; ?></label>
      <div class="col-lg-10">
        <textarea class="form-control" rows="3" name="mensaje" placeholder="<?php echo $lang[106]; ?> <?php echo $user_enviado; ?>" id="textArea"></textarea>
        
      </div>
    </div>
<br>
    <div class="form-group">
      <div class="col-lg-10 col-lg-offset-2">
        <button type="reset" data-dismiss="modal" class="btn btn-default"><?php echo $lang[68]; ?></button>
        <button type="submit" name="guardar" class="btn btn-primary"><?php echo $lang[144]; ?></button>
      </div>
    </div>
  </fieldset>
</form>
		  
        </div>
      </div>
      
    </div>
  </div>
						<?php } ?>
            </tbody>
			</table>
			
  <?php
if ($_POST['mensaje'] && $_POST['asunto']) {
	  if($_SESSION["logeado"] == "SI"){
	$fecha_log = date("Y-m-d");
$enviar1 = "INSERT INTO usuarios_mensajes_privados (user_enviado,user_recibido,asunto,mensaje,fecha) values ('".$usuario_activo."','".$user_enviado."','".strip_tags($_POST['asunto'])."','".strip_tags($_POST['mensaje'])."','".$fecha_log."')";

if ($link->query($enviar1)) { 
  
// Guardar acción en Logs si se ha iniciado sesión

$accion = "$lang[116] $user_enviado";
$enviar_log = "INSERT INTO logs (usuario,accion,fecha) values ('".$usuario_activo."','".$accion."','".$fecha_log."')";
$link->query($enviar_log);
// Log guardado en Base de datos
  
echo "<div class='alert alerta-si alert-dismissible'><button type='button' class='close' data-dismiss='alert'>×</button>$lang[99]: $user_enviado $lang[71]</div>";
	  }}else {
	echo "<div class='alert alerta-no alert-dismissible'><button type='button' class='close' data-dismiss='alert'>×</button>$lang[100]</div>";
}
  }
?>

			
			<?php } ?>
								</div>
				</div>
			
			<div class="panel panel-default">
							<div class="panel-heading green">
						<h3 class="panel-title"><?php echo $lang[132]; ?></h3>
					</div>
				<div class="panel-body">
				
				<?php 
$mensajes_enviados = $link->query("SELECT * FROM usuarios_regalos WHERE user_enviado = '".$usuario_activo."'");
$mensajes_enviados_r = mysqli_num_rows($mensajes_enviados);
			if("$mensajes_enviados_r" == "0"){
					echo "<div class='alert alerta-no alert-dismissible'><button type='button' class='close' data-dismiss='alert'>×</button>$lang[146]</div>";
			} else {
				?>
<table class="table table-striped">
            <thead>
              <tr>
                <th><?php echo $lang[138]; ?></th>
                <th><?php echo $lang[96]; ?></th>
                <th><?php echo $lang[103]; ?></th>
				<th><?php echo $lang[147]; ?></th>
              </tr>
            </thead>
            <tbody>
						<?php
						$resultado = $link->query("SELECT * FROM usuarios_regalos WHERE user_enviado = '".$usuario_activo."' ORDER BY id DESC");
						while($row = mysqli_fetch_array($resultado)){
							$user_recibido = $row['user_recibido'];
							$user_enviado = $row['user_enviado'];
							$asunto_regalo1 = $row['asunto_regalo'];
							$mensaje_regalo1 = $row['mensaje_regalo'];
							$regalo = $row['code_placa'];
							$id_regalo = md5($row['id']);
							?>
              <tr>
			    <td><?php echo $user_recibido; ?></button>
                <td><?php echo $asunto_regalo1; ?></td>
				<td>Placa: <?php echo $regalo; ?></button>
                <td><button data-toggle="modal" data-target="#ver_regalo_<?php echo $id_regalo; ?>" class='btn btn-xs btn-default'><?php echo $lang[148]; ?></button></td>
              			     
              			      <!-- Modal -->
  <div class="modal fade" id="ver_regalo_<?php echo $id_regalo; ?>" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title"><?php echo $lang[149]; ?> <a href="<?php echo $url; ?>/perfil.php?user=<?php echo $user_recibido; ?>"><?php echo $user_recibido; ?></a></h4>
        </div>
        <div class="modal-body">
		  
<form class="form-horizontal" action="ajustes.php?regalos" method="post" enctype="multipart/form-data">
  <fieldset>
    <div class="form-group">
      <label class="col-lg-2 control-label"><?php echo $lang[96]; ?>:</label>
      <div class="col-lg-10">
        <?php echo $asunto_regalo1; ?>
      </div>
    </div>
<br>
    <div class="form-group">
      <label class="col-lg-2 control-label"><?php echo $lang[110]; ?>:</label>
      <div class="col-lg-10">
        <?php echo $mensaje_regalo1; ?>
      </div>
    </div>
<br>
    <div class="form-group">
      <label for="inputEmail" class="col-lg-2 control-label"><?php echo $lang[103]; ?>:</label>
      <div class="col-lg-10">
        <?php echo $lang[42]; ?>: <?php echo $regalo; ?> 
								<?php 
						$placa1=$link->query("SELECT * FROM placas WHERE code = '".$regalo."'");
						while($row = mysqli_fetch_array($placa1)){
							$imagen_placa = $row['imagen']; ?>
						<img src="<?php echo $imagen_placa; ?>">
						<?php } ?>
      </div>
    </div>
  </fieldset>
</form>
		  
        </div>
      </div>
      
    </div>
  </div>
              </tr>
			  
						<?php } ?>
            </tbody>
			</table>

			<?php } ?>
								</div>
				</div>
			<?php } ?>
		
			<?php if(isset($_GET['mensajes'])){?>

            
								<div class="panel panel-default">
							<div class="panel-heading red">
						<h3 class="panel-title"><?php echo $lang[150]; ?></h3>
					</div>
				<div class="panel-body">
				
				<?php 
$mensajes_recibidos = $link->query("SELECT * FROM usuarios_mensajes_privados WHERE user_recibido = '".$username."'");
$mensajes_recibidos_r = mysqli_num_rows($mensajes_recibidos);
			if("$mensajes_recibidos_r" == "0"){
					echo "<div class='alert alerta-no alert-dismissible'><button type='button' class='close' data-dismiss='alert'>×</button>$lang[151]</div>";
			} else {
				?>
<table class="table table-striped">
            <thead>
              <tr>
                <th><?php echo $lang[137]; ?></th>
                <th><?php echo $lang[96]; ?></th>
				        <th><?php echo $lang[140]; ?></th>
              </tr>
            </thead>
            <tbody>
						<?php 
						$resultado = $link->query("SELECT * FROM usuarios_mensajes_privados WHERE user_recibido = '".$username."' ORDER BY id DESC");
						while($row = mysqli_fetch_array($resultado)){
							$user_enviado = $row['user_enviado'];
							$asunto_mensaje = $row['mensaje'];
							$id_mensaje = md5($row['id']);
							$asunto_recibido = $row['asunto'];
							$mensaje_recibido = $row['mensaje'];
							?>
              <tr>
			          <td><?php echo $user_enviado; ?></button>
                <td><?php echo $asunto_recibido; ?></td>
                <td><button data-toggle="modal" data-target="#enviar_mensaje" class='btn btn-xs btn-default'>Responder</button> <button data-toggle="modal" data-target="#ver_mensaje_<?php echo $id_mensaje; ?>" class='btn btn-xs btn-default'><?php echo $lang[140]; ?></button></td>
              </tr>
			  
			      <!-- Modal -->
  <div class="modal fade" id="ver_mensaje_<?php echo $id_mensaje; ?>" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title"><?php echo $lang[153]; ?> <a href="<?php echo $url; ?>/perfil.php?user=<?php echo $user_enviado; ?>"><?php echo $user_enviado; ?></a></h4>
        </div>
        <div class="modal-body">
		  
<form class="form-horizontal" action="ajustes.php?mensajes" method="post" enctype="multipart/form-data">
  <fieldset>
    <div class="form-group">
      <label for="inputEmail" class="col-lg-2 control-label"><?php echo $lang[96]; ?>:</label>
      <div class="col-lg-10">
        <?php echo $asunto_recibido; ?>
      </div>
    </div>
<br>
    <div class="form-group">
      <label for="textArea" class="col-lg-2 control-label"><?php echo $lang[97]; ?>:</label>
      <div class="col-lg-10">
        <?php echo $mensaje_recibido; ?>
        
      </div>
    </div>
  </fieldset>
</form>
		  
        </div>
      </div>
      
    </div>
  </div>
			  
			  <!-- Modal -->
  <div class="modal fade" id="enviar_mensaje" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title"><?php echo $lang[154]; ?> <a href="<?php echo $url; ?>/perfil.php?user=<?php echo $user_enviado; ?>"><?php echo $user_enviado; ?></a></h4>
        </div>
        <div class="modal-body">
		  
<form class="form-horizontal" action="ajustes.php?mensajes" method="post" enctype="multipart/form-data">
  <fieldset>
    <div class="form-group">
      <label for="inputEmail" class="col-lg-2 control-label"><?php echo $lang[96]; ?></label>
      <input type="hidden" name="user_enviado" value="<?php echo $user_enviado; ?>"/>
      <div class="col-lg-10">
        <input type="text" class="form-control" name="asunto" value="<?php echo $lang[155]; ?>: <?php echo $asunto_recibido; ?>" placeholder="">
      </div>
    </div>
´<br>
    <div class="form-group">
      <label for="textArea" class="col-lg-2 control-label"><?php echo $lang[97]; ?></label>
      <div class="col-lg-10">
        <textarea class="form-control" rows="3" name="mensaje" placeholder="<?php echo $lang[106]; ?> <?php echo $user_enviado; ?>" id="textArea"></textarea>
      </div>
    </div>
<br>
    <div class="form-group">
      <div class="col-lg-10 col-lg-offset-2">
        <button type="reset" data-dismiss="modal" class="btn btn-default"><?php echo $lang[68]; ?></button>
        <button type="submit" name="guardar" class="btn btn-primary"><?php echo $lang[98]; ?></button>
      </div>
    </div>
  </fieldset>
</form>
		  
        </div>
      </div>
      
    </div>
  </div>
						<?php } ?>
            </tbody>
			</table>
  			    <?php
if ($_POST['mensaje'] && $_POST['asunto']) {
	  if($_SESSION["logeado"] == "SI"){
	$fecha_log = date("Y-m-d");
$enviar1 = "INSERT INTO usuarios_mensajes_privados (user_enviado,user_recibido,asunto,mensaje,fecha) values ('".$usuario_activo."','".$_POST['user_enviado']."','".strip_tags($_POST['asunto'])."','".strip_tags($_POST['mensaje'])."','".$fecha_log."')";

if ($link->query($enviar1)) { 
  
// Guardar acción en Logs si se ha iniciado sesión

$accion = "$lang[116] $_POST[user_enviado]";
$enviar_log = "INSERT INTO logs (usuario,accion,fecha) values ('".$usuario_activo."','".$accion."','".$fecha_log."')";
$link->query($enviar_log);
// Log guardado en Base de datos
  
echo "<div class='alert alerta-si alert-dismissible'><button type='button' class='close' data-dismiss='alert'>×</button>$lang[99]: $user_enviado $lang[71]</div>";
    }}else {
  echo "<div class='alert alerta-no alert-dismissible'><button type='button' class='close' data-dismiss='alert'>×</button>$lang[100]</div>";
}
  }
?>
			
			<?php } ?>
								</div>
				</div>
			<div class="panel panel-default">
							<div class="panel-heading blue">
						<h3 class="panel-title"><?php echo $lang[156]; ?></h3>
					</div>
				<div class="panel-body">
				
				<?php 
$mensajes_enviados = $link->query("SELECT * FROM usuarios_mensajes_privados WHERE user_enviado = '".$username."'");
$mensajes_enviados_r = mysqli_num_rows($mensajes_enviados);
			if("$mensajes_enviados_r" == "0"){
					echo "<div class='alert alerta-no alert-dismissible'><button type='button' class='close' data-dismiss='alert'>×</button>$lang[157]</div>";
			} else {
				?>
<table class="table table-striped">
            <thead>
              <tr>
                <th><?php echo $lang[138]; ?></th>
                <th><?php echo $lang[96]; ?></th>
				        <th><?php echo $lang[140]; ?></th>
              </tr>
            </thead>
            <tbody>
						<?php 
						$resultado = $link->query("SELECT * FROM usuarios_mensajes_privados WHERE user_enviado = '".$username."' ORDER BY id DESC");
						while($row = mysqli_fetch_array($resultado)){
							$user_recibido = $row['user_recibido'];
							$asunto_mensaje1 = $row['asunto'];
							$mensaje_mensaje1 = $row['mensaje'];
							$id_mensaje = md5($row['id']);
							?>
              <tr>
			          <td><?php echo $user_recibido; ?></button>
                <td><?php echo $asunto_mensaje1; ?></td>
                <td><button data-toggle="modal" data-target="#ver_mensaje_<?php echo $id_mensaje; ?>" class='btn btn-xs btn-default'><?php echo $lang[152]; ?></button></td>
              </tr>
			  
			      <!-- Modal -->
  <div class="modal fade" id="ver_mensaje_<?php echo $id_mensaje; ?>" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title"><?php echo $lang[158]; ?> <a href="<?php echo $url; ?>/perfil.php?user=<?php echo $user_recibido; ?>"><?php echo $user_recibido; ?></a></h4>
        </div>
        <div class="modal-body">
		  
<form class="form-horizontal" action="ajustes.php?mensajes" method="post" enctype="multipart/form-data">
  <fieldset>
    <div class="form-group">
      <label class="col-lg-2 control-label"><?php echo $lang[96]; ?>:</label>
      <div class="col-lg-10">
        <?php echo $asunto_mensaje1; ?>
      </div>
    </div>
<br>
    <div class="form-group">
      <label class="col-lg-2 control-label"><?php echo $lang[97]; ?>:</label>
      <div class="col-lg-10">
        <?php echo $mensaje_mensaje1; ?>
      </div>
    </div>
  </fieldset>
</form>
		  
        </div>
      </div>
      
    </div>
  </div>
			  
						<?php } ?>
            </tbody>
			</table>

			<?php } ?>
								</div>
				</div>
			<?php } ?>
		
			<?php if(isset($_GET['amigos'])){?>

            
								<div class="panel panel-default">
							<div class="panel-heading green">
						<h3 class="panel-title"><?php echo $lang[21]; ?></h3>
					</div>
				<div class="panel-body">
				
				<?php 
$amigos = $link->query("SELECT * FROM usuarios_amigos WHERE user = '".$username."'");
$amigos_r = mysqli_num_rows($amigos);
			if("$amigos_r" == "0"){
					echo "<div class='alert alerta-no alert-dismissible'><button type='button' class='close' data-dismiss='alert'>×</button>$lang[159]</div>";
			} else {
				?>
<table class="table table-striped">
            <thead>
              <tr>
			    <th></th>
                <th><?php echo $lang[123]; ?></th>
                <th><?php echo $lang[160]; ?></th>
				        <th><?php echo $lang[147]; ?></th>
              </tr>
            </thead>
            <tbody>
						<?php 
						$resultado = $link->query("SELECT * FROM usuarios_amigos WHERE user = '".$username."'");
						while($row = mysqli_fetch_array($resultado)){
							$usuarios_amigo = $row['user_amigo'];
							$id_solicitud = $row['id'];
              $user_enavido1 = $row['user'];
							
							if($row['estado_solicitud'] == 'Confirmado'){
							$estado = "<form class='form-horizontal' action='$url/ajustes?amigos' method='post' enctype='multipart/form-data'>
							<button class='btn btn-xs btn-success'>$lang[161]</button> <input type='hidden' readonly='readonly' name='id_verificar' value='$id_solicitud'> <button type='submit' name='eliminar' class='btn btn-xs btn-danger'>$lang[162]</button>
							</form>";
							} else {
								$estado = "<form class='form-horizontal' action='$url/ajustes?amigos' method='post' enctype='multipart/form-data'>
								<button type='submit' name='aceptar' class='btn btn-xs btn-success'>$lang[163]</button> 
								<button type='submit' name='rechazar' class='btn btn-xs btn-danger'>$lang[164]</button>
								</form>
								"; 
							}
							?>
              <tr>
			    <td></td>
                <td><?php echo $usuarios_amigo; ?></td>
                <td><?php echo $estado; ?></td>
				<td><a href="<?php echo $url; ?>/perfil.php?user=<?php echo $usuarios_amigo; ?>"><button type="button" class="btn btn-xs btn-default"><?php echo $lang[165]; ?></button></a></td>
              </tr>
						<?php } ?>
            </tbody>
			</table>
			<?php } ?>
											</div>
				</div>
	  
			<?php
if (isset($_POST['aceptar'])) {
	  if($_SESSION["logeado"] == "SI"){
	$fecha_log = date("Y-m-d");
	
$enviar1 = "UPDATE usuarios_amigos SET estado_solicitud='Confirmado' WHERE id = $id_solicitud";
$enviar2 = "INSERT INTO usuarios_amigos (user,user_amigo,estado_solicitud) values ('".$usuarios_amigo."','".$username."','Confirmado')";

if ($link->query($enviar1)) { 
if ($link->query($enviar2)) { 
echo "<div style='border-radius:5px;padding:10px;background-color:green;color:#fff;'>$lang[166] $usuarios_amigo $lang[167]</div>";
	  }}}else {
	echo "<div style='border-radius:5px;padding:10px;background-color:red;color:#fff;'>$lang[168]</div>";
}
  }
?>

	      <?php
if (isset($_POST['eliminar'])) {
	  if($_SESSION["logeado"] == "SI"){
	$fecha_log = date("Y-m-d");

  $id_verificar = $_POST['id_verificar'];

  $verificar = $link->query("SELECT * FROM usuarios_amigos WHERE (id = '".$id_verificar."') AND (user = '".$usuario_activo."')");
  while ($row = mysqli_fetch_array($verificar)) {
    $nombre_amigo_user = $row['user_amigo'];
  }
	
$enviar1 = "DELETE FROM usuarios_amigos WHERE (user = '".$nombre_amigo_user."') AND (user_amigo = '".$username."')";
$enviar2 = "DELETE FROM usuarios_amigos WHERE (user = '".$username."') AND (user_amigo = '".$nombre_amigo_user."')";

if ($link->query($enviar1)) { 
if ($link->query($enviar2)) { 
echo "<div style='border-radius:5px;padding:10px;background-color:green;color:#fff;'>$lang[170] $nombre_amigo_user $lang[171]</div>";
	  }}}else {
	echo "<div style='border-radius:5px;padding:10px;background-color:red;color:#fff;'>$lang[172]</div>";
}
  }
?>

	      <?php
if (isset($_POST['rechazar'])) {
	  if($_SESSION["logeado"] == "SI"){
	$fecha_log = date("Y-m-d");
	
$enviar1 = "DELETE FROM usuarios_amigos WHERE id = $id_solicitud";
$enviar2 = "DELETE FROM usuarios_amigos WHERE (user = '".$usuarios_amigo."') AND (user_amigo = '".$username."')";

if ($link->query($enviar1)) { 
echo "<div style='border-radius:5px;padding:10px;background-color:green;color:#fff;'>$lang[169]</div>";
	  }}else {
	echo "<div style='border-radius:5px;padding:10px;background-color:red;color:#fff;'>$lang[173]</div>";
}
  }
?>
															
			<?php 
	         }   
			?>

<?php

if(isset($_GET['ajustes'])){
$default_ajuste = 0;
    }

if(isset($_GET['amigos'])){
$default_ajuste = 0;
    }

if(isset($_GET['mensajes'])){
$default_ajuste = 0;
    }

if(isset($_GET['guardado'])){
$default_ajuste = 1;
    }

if(isset($_GET['no-guardado'])){
$default_ajuste = 1;
    }

if(empty($_GET)){
$default_ajuste = 1;
    }


  ?>
			
		
			<?php if($default_ajuste == 1){ ?>
	<div class="panel panel-default">
            <div class="panel-heading orange">
              <h3 class="panel-title"><?php echo $lang[174]; ?></h3>
            </div>
            <div class="panel-body">
			<div class="eventotext">

<form action="ajustes.php" method="post" enctype="multipart/form-data">
        <?php

  $query = $link->query('SELECT * FROM usuarios WHERE username = "' .$username. '"');
  while($row = mysqli_fetch_array($query))
  {
  ?>
        <input type="hidden" name="id" value="<?php echo $row['ID'];?>"/>

			<label><?php echo $lang[175]; ?></label>
            <div class="input-group date">
            <input type="text" id="nacimiento" class="form-control" name="username" placeholder="<?php echo $lang[175]; ?>" aria-describedby="basic-addon2" value="<?php echo $_SESSION['username']?>" readonly="">
            </div>  <br>

             <label><?php echo $lang[50]; ?> </label>
            <input style="margin-bottom: 10px;" type="email" class="form-control" name="email" placeholder="<?php echo $lang[176]; ?>" required="" value="<?php echo $row['email'];?>" />  <br>

            <label><?php echo $lang[177]; ?></label>
            <div class="input-group date">
            <input type="text" id="nacimiento" class="form-control" name="fecha" placeholder="<?php echo $lang[177]; ?>" aria-describedby="basic-addon2" value="<?php echo $row['fecha'];?>" readonly="">
            </div>    <br>

			<label><?php echo 'Avatar:'; ?></label>
                <img class="media-object" src="<?php echo $row['avatar'];?>" width="70" height="100" />

            <br>
            <?php
            }
            ?>
            <center><input class="btn btn-primary" name="guardar" type="submit" value="<?php echo $lang[192]; ?>" style="width: 120px;" /></center>
              </form>

              <?php
              if ($_POST['guardar'] && $_POST['guardar']) {
$query = $link->query("SELECT * FROM usuarios WHERE username = '" .$username. "'");
while($row = mysqli_fetch_array($query))
{
  $rowid = $row['ID'];
  $id = $_POST['id'];
  $username_actual = $row['username'];
}
  if("$rowid" == "$id") {
    $avatar1 = strip_tags($_POST['avatar']);
    $email = strip_tags($_POST['email']);
    $pais = strip_tags($_POST['pais']);
    $seguridad_ip = strip_tags($_POST['seguridad_ip']);
    $nombre = strip_tags($_POST['nombre']);
    $mostrar_email = strip_tags($_POST['mostrar_email']);
    $mostrar_nombre_apellido = strip_tags($_POST['mostrar_nombre_apellido']);
    $mostrar_pais = strip_tags($_POST['mostrar_pais']);
	$portada = strip_tags($_POST['portada']);
    $apellido = strip_tags($_POST['apellido']);

      $img = $_FILES['img'];
    if(!empty($_FILES['img'])){
     $filename = $img['tmp_name'];
     $client_id="468f0619555e33e";
     $handle = fopen($filename, "r");
     $data = fread($handle, filesize($filename));
     $pvars   = array('image' => base64_encode($data));
     $timeout = 30;
     $curl    = curl_init();
     curl_setopt($curl, CURLOPT_URL, 'https://api.imgur.com/3/image.json');
     curl_setopt($curl, CURLOPT_TIMEOUT, $timeout);
     curl_setopt($curl, CURLOPT_HTTPHEADER, array('Authorization: Client-ID ' . $client_id));
     curl_setopt($curl, CURLOPT_POST, 1);
     curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
     curl_setopt($curl, CURLOPT_POSTFIELDS, $pvars);
     $out = curl_exec($curl);
     curl_close ($curl);
     $pms = json_decode($out,true);
     $url=$pms['data']['link'];
     $fecha = date("d/m/Y");
     if("$url" != ""){
     $avatar = $url;
       $link->query("INSERT INTO images (url,fecha) values ('".$url."','".$fecha."')");

     }else{
           $avatar = $avatar1;
     header("Location: ajustes.php?no-guardado");
      echo $pms['data']['error']['message'];
    } } else {
      $avatar = $avatar1;
    }

    $consulta = "UPDATE usuarios SET avatar='$avatar', email='$email', pais='$pais', nombre='$nombre', mostraremail='$mostrar_email', mostrarnombreapellido='$mostrar_nombre_apellido', mostrarpais='$mostrar_pais', apellido='$apellido', portada='$portada', seguridad_ip='$seguridad_ip' WHERE id='$id'";
    $consulta1 = "UPDATE comentarios SET avatar='$avatar' WHERE username='$username_actual'";

// Guardar acción en Logs si se ha iniciado sesión
$fecha_log = date("Y-m-d");
$accion = "$lang[193]";
$enviar_log = "INSERT INTO logs (usuario,accion,fecha) values ('".$username."','".$accion."','".$fecha_log."')";
$link->query($enviar_log);
// Log guardado en Base de datos

   $link->query($consulta);
   $link->query($consulta1);

    header("Location: ajustes.php?guardado");
} else {
  header("Location: ajustes.php?no-guardado");
              }}


?>

			</div>
          </div>
		 </div>
		 <?php } ?>
		</div>

        <div class="col-md-4">
        <?php echo $cartel_radio; ?>
<?php echo $redes_sociales; ?>

<?php echo $cartel_publicidad; ?>

		</div>
      </div>

    </div> <!-- /container -->