<?php
$username = $_GET['user'];
$consulta = "SELECT *FROM usuarios WHERE username = '$username' LIMIT 1";
 $filas = $link->query($consulta);
  $columnas = mysqli_fetch_assoc($filas);

  $verificacion = mysqli_num_rows($filas);

  if ($verificacion == 0) {

    echo "<div class='alert alerta-no alert-dismissible'><button type='button' class='close' data-dismiss='alert'>×</button>$lang[111]</div>";

    echo "<center><div><img style='margin:25px;' src='https://cdn.habtium.com/album/3/Galeria_Habbo/Frank/register4.gif'></div></center>";

    include "Templates/Footer.php";
    exit();
  }
?>
<div class="container">
	<div class="row">
		<div class="col-md-8">
			<center>
			<div class="registro">
				<div class="panel panel-default">
					<div class="panel-heading green">
						<h3 class="panel-title"><?php echo $columnas['username']; ?>
						</h3>
					</div>
					<div class="panel-body">
						<div class="eventotext">
							<div style="height: 220px;background: url(<?php echo $columnas['portada']; ?>);margin: -15px -15px 0px -15px;background-color: #c5b6b6;background-position: 100% 100%;">
								<div class="col-md-8">
									<div class="usercontenedor1">
										<center>
										<div style="background-color:#fff" class="userperfileindex1">
											<img src="<?php echo $columnas['avatar']; ?>" alt="" style="width:64px;height:110px;">
										</div>
										</center>
									</div>
								</div>
							</div>
						</div>
						<div style="float: rigth;overflow: hidden;">
						<div class="menu-perfil">
						<?php 
						if ($columnas['username'] != $usuario_activo){
if($_SESSION["logeado"] == "SI"){
$enviar_mensaje = '#enviar_mensaje';
$solicitud = '#solicitud';
$enviar_regalo = '#enviar_regalo';
$reportar = '#reportar';
} else { 
	$enviar_mensaje = '#anonimo';
	$enviar_regalo = '#anonimo';
    $reportar = '#anonimo';
	$solicitud = '#anonimo';
}
						?>
  <?php 
						}else{?>
							  <a class="seccion-perfil" href="<?php echo $url; ?>/ajustes"><?php echo $lang[59]; ?></a>
						<?php } ?>
</div>
					<?php	if ($columnas['username'] != $usuario_activo){?>
<!-- Modal -->
  <div class="modal fade" id="anonimo" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title"><?php echo $lang[63]; ?></h4>
        </div>
        <div class="modal-body">
		<p><?php echo $lang[64]; ?></p>

        <a href="<?php echo $url; ?>/registro"><button class="btn btn-warning"><?php echo $lang[48]; ?></button></a>
        <a href="<?php echo $url; ?>/login"><button class="btn btn-primary"><?php echo $lang[24]; ?></button></a>
      </div>
    </div>
		  
        </div>
      </div>
	  <?php 
	  if($_SESSION["logeado"] == "SI"){
	  ?>
	  <!-- Modal -->
  <div class="modal fade" id="solicitud" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title"><?php echo $lang[66]; ?></h4>
        </div>
        <div class="modal-body">
		<form class="form-horizontal" action="perfil.php?user=<?php echo $columnas['username']; ?>" method="post" enctype="multipart/form-data">
		<p><?php echo $lang[67]; ?> <?php echo $columnas['username']; ?>?</p>

        <button type="reset" data-dismiss="modal" class="btn btn-default"><?php echo $lang[68]; ?></button>
        <button type="submit" name="confirmar" class="btn btn-primary"><?php echo $lang[69]; ?></button>
		</form>
      </div>
    </div>
		  
        </div>
      </div>
	  
	      <?php
if (isset($_POST['confirmar'])) {
	  if($_SESSION["logeado"] == "SI"){
	$fecha_log = date("Y-m-d");
	$user_perfil1 = $columnas['username'];

$amigos_confirmado = $link->query("SELECT * FROM usuarios_amigos WHERE (user = '".$columnas['username']."') AND (user_amigo = '".$usuario_activo."') AND (estado_solicitud = 'Confirmado')");
$amigos_confirmado_r = mysqli_num_rows($amigos_confirmado);

if("$amigos_confirmado_r" == "0") {

$amigos1 = $link->query("SELECT * FROM usuarios_amigos WHERE (user = '".$columnas['username']."') AND (user_amigo = '".$usuario_activo."')");
$amigos1_r = mysqli_num_rows($amigos1);

$amigos2 = $link->query("SELECT * FROM usuarios_amigos WHERE (user = '".$usuario_activo."') AND (user_amigo = '".$columnas['username']."')");
$amigos2_r = mysqli_num_rows($amigos2);

if("$amigos1_r" == "0"){
if("$amigos2_r" == "0"){

$enviar1 = "INSERT INTO usuarios_amigos (user,user_amigo,estado_solicitud) values ('".$columnas['username']."','".$usuario_activo."','Pendiente')";
$user_report = strip_tags($_POST['user_report']);
if ($link->query($enviar1)) { 
  
// Guardar acción en Logs si se ha iniciado sesión

$accion = "$lang[118] $columnas[username]";
$enviar_log = "INSERT INTO logs (usuario,accion,fecha) values ('".$usuario_activo."','".$accion."','".$fecha_log."')";
$link->query($enviar_log);
// Log guardado en Base de datos
  
echo "<div class='alert alerta-si alert-dismissible'><button type='button' class='close' data-dismiss='alert'>×</button>$lang[70] $columnas[username] $lang[71]</div>";
    }else {
  echo "<div class='alert alerta-no alert-dismissible'><button type='button' class='close' data-dismiss='alert'>×</button>$lang[72]</div>";
}
 }
   } else { echo "<div class='alert alerta-no alert-dismissible'><button type='button' class='close' data-dismiss='alert'>×</button>$lang[73] $user_perfil1</div>"; }
   } else { echo "<div class='alert alerta-si alert-dismissible'><button type='button' class='close' data-dismiss='alert'>×</button>$columnas[username] $lang[74]</div>"; }
  }
    }
?>
 

  <!-- Modal -->
  <div class="modal fade" id="reportar" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title"><?php echo $lang[75]; ?></h4>
        </div>
        <div class="modal-body">
		  
<form class="form-horizontal" action="perfil.php?user=<?php echo $columnas['username']; ?>" method="post" enctype="multipart/form-data">
  <fieldset>
    <div class="form-group">
      <label for="inputEmail" class="col-lg-2 control-label"><?php echo $lang[76]; ?></label>
      <div class="col-lg-10">
        <input type="text" class="form-control" name="user_report" value="<?php echo $columnas['username']; ?>" placeholder="Usuario Reportado">
      </div>
    </div>
	
	    <div class="form-group">
      <label for="select" class="col-lg-2 control-label"><?php echo $lang[77]; ?></label>
      <div class="col-lg-10">
      </div>
    </div>

    <div class="form-group">
      <label for="textArea" class="col-lg-2 control-label"><?php echo $lang[90]; ?></label>
      <div class="col-lg-10">
        <textarea class="form-control" name="mensaje" rows="3" placeholder="<?php echo $lang[194]; ?>" id="textArea"></textarea>
        <span class="help-block"><?php echo $lang[91]; ?></span>
      </div>
    </div>

    <div class="form-group">
      <div class="col-lg-10 col-lg-offset-2">
        <button type="reset" data-dismiss="modal" class="btn btn-default"><?php echo $lang[68]; ?></button>
        <button type="submit" class="btn btn-primary"><?php echo $lang[92]; ?></button>
      </div>
    </div>
  </fieldset>
</form>
		  
        </div>
      </div>
      
    </div>
  </div>
  
    <?php
if ($_POST['user_report'] && $_POST['mensaje'])  {
	  if($_SESSION["logeado"] == "SI"){
	$fecha_log = date("Y-m-d");
	$user_perfil1 = $columnas['username'];
	$estado_report = 'Activo';
$enviar1 = "INSERT INTO reportes (user_enviado,user_reportado,mensaje,fecha_i,tipo,estado) values ('".$usuario_activo."','".strip_tags($_POST['user_report'])."','".strip_tags($_POST['mensaje'])."','".$fecha_log."','".strip_tags($_POST['tipo'])."','".$estado_report."')";
$user_report = strip_tags($_POST['user_report']);
if ($link->query($enviar1)) { 
  
// Guardar acción en Logs si se ha iniciado sesión

$accion = "$lang[117] $user_report";
$enviar_log = "INSERT INTO logs (usuario,accion,fecha) values ('".$usuario_activo."','".$accion."','".$fecha_log."')";
$link->query($enviar_log);
// Log guardado en Base de datos
  
echo "<div class='alert alerta-si alert-dismissible'><button type='button' class='close' data-dismiss='alert'>×</button>$lang[93] $user_report</div>";

	  }}else {
	echo "<div class='alert alerta-no alert-dismissible'><button type='button' class='close' data-dismiss='alert'>×</button>$lang[94]</div>";
}
  }
?>
  
    <!-- Modal -->
  <div class="modal fade" id="enviar_mensaje" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title"><?php echo $lang[95]; ?> <?php echo $columnas['username']; ?></h4>
        </div>
        <div class="modal-body">
		  
<form class="form-horizontal" action="perfil.php?user=<?php echo $columnas['username']; ?>" method="post" enctype="multipart/form-data">
  <fieldset>
    <div class="form-group">
      <label for="inputEmail" class="col-lg-2 control-label"><?php echo $lang[96]; ?></label>
      <div class="col-lg-10">
        <input type="text" class="form-control" name="asunto" value="<?php echo $lang[105]; ?>" placeholder="<?php echo $lang[76]; ?>">
      </div>
    </div>

    <div class="form-group">
      <label for="textArea" class="col-lg-2 control-label"><?php echo $lang[97]; ?></label>
      <div class="col-lg-10">
        <textarea class="form-control" rows="3" name="mensaje" placeholder="<?php echo $lang[106]; ?> <?php echo $columnas['username']; ?>" id="textArea"></textarea>
        <span class="help-block"></span>
      </div>
    </div>

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
  
  <?php
if ($_POST['mensaje'] && $_POST['asunto']) {
	  if($_SESSION["logeado"] == "SI"){
	$fecha_log = date("Y-m-d");
	$user_perfil1 = $columnas['username'];
$enviar1 = "INSERT INTO usuarios_mensajes_privados (user_enviado,user_recibido,asunto,mensaje,fecha) values ('".$usuario_activo."','".$user_perfil1."','".strip_tags($_POST['asunto'])."','".strip_tags($_POST['mensaje'])."','".$fecha_log."')";

if ($link->query($enviar1)) { 
  
// Guardar acción en Logs si se ha iniciado sesión

$accion = "$lang[116] $columnas[username]";
$enviar_log = "INSERT INTO logs (usuario,accion,fecha) values ('".$usuario_activo."','".$accion."','".$fecha_log."')";
$link->query($enviar_log);
// Log guardado en Base de datos
  
echo "<div class='alert alerta-si alert-dismissible'><button type='button' class='close' data-dismiss='alert'>×</button>$lang[99] $user_perfil1 $lang[71]</div>";

	  }}else {
	echo "<div class='alert alerta-no alert-dismissible'><button type='button' class='close' data-dismiss='alert'>×</button>$lang[100]</div>";
}
  }
?>
  
  <!-- Modal -->
  <div class="modal fade" id="enviar_regalo" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title"><?php echo $lang[101]; ?> <?php echo $columnas['username']; ?></h4>
        </div>
        <div class="modal-body">
		  
<form class="form-horizontal" action="perfil.php?user=<?php echo $columnas['username']; ?>" method="post" enctype="multipart/form-data">
  <fieldset>
    <div class="form-group">
      <label for="inputEmail" class="col-lg-2 control-label"><?php echo $lang[96]; ?></label>
      <div class="col-lg-10">
        <input type="text" class="form-control" name="asunto_regalo" id="inputEmail" value="<?php echo $lang[105]; ?>" placeholder="<?php echo $lang[102]; ?>">
      </div>
    </div>
	
	    <div class="form-group">
      <label for="select" class="col-lg-2 control-label"><?php echo $lang[103]; ?></label>
      <div class="col-lg-10">
        <select class="form-control" name="regalo" id="select">
          <option><?php echo $lang[104]; ?></option>
                      <?php
                      $resultado = $link->query("SELECT * FROM usuarios_placas WHERE username = '".$usuario_activo."' ORDER BY id DESC");
                      while($row=mysqli_fetch_array($resultado))
                      {
                      ?>
                     
                    <option value="<?php echo "$row[code_placa]"; ?>"><?php echo $lang[42]; ?>: <?php echo "$row[code_placa]"; ?></option>
					<?php
                      }
                    ?>
        </select>
      </div>
    </div>

    <div class="form-group">
      <label for="textArea" class="col-lg-2 control-label"><?php echo $lang[107]; ?></label>
      <div class="col-lg-10">
        <textarea class="form-control" name="mensaje_regalo" rows="3" placeholder="<?php echo $lang[108]; ?>" id="textArea"></textarea>
        <span class="help-block"></span>
      </div>
    </div>

    <div class="form-group">
      <div class="col-lg-10 col-lg-offset-2">
        <button type="reset" data-dismiss="modal" class="btn btn-default"><?php echo $lang[68]; ?></button>
        <button type="submit" class="btn btn-primary"><?php echo $lang[109]; ?></button>
      </div>
    </div>
  </fieldset>
</form>
		  
        </div>
      </div>
      
    </div>
  </div>
  
    <?php
if ($_POST['asunto_regalo'] && $_POST['regalo']) {
	  if($_SESSION["logeado"] == "SI"){
	$fecha_log = date("Y-m-d");
	$user_perfil1 = $columnas['username'];
	
$placas_existente = $link->query("SELECT * FROM usuarios_placas WHERE (username='".$usuario_activo."') AND (code_placa='".$_POST['regalo']."')");
$placa_existente_r = mysqli_num_rows($placas_existente);

$placa_inventario = $link->query("SELECT * FROM usuarios_placas WHERE (username='".$user_perfil1."') AND (code_placa='".$_POST['regalo']."')");
$placa_inventario_r = mysqli_num_rows($placa_inventario);

if("$placa_inventario_r" != "0"){
    echo "<div class='alert alerta-no alert-dismissible'><button type='button' class='close' data-dismiss='alert'>×</button>$lang[112]</div>";
} else {

if("$placa_existente_r" == "0"){
		echo "<div class='alert alerta-no alert-dismissible'><button type='button' class='close' data-dismiss='alert'>×</button>$lang[114]</div>";
}

$enviar1 = "INSERT INTO usuarios_regalos (user_enviado,user_recibido,asunto_regalo,mensaje_regalo,fecha,code_placa) values ('".$usuario_activo."','".$user_perfil1."','".strip_tags($_POST['asunto_regalo'])."','".strip_tags($_POST['mensaje_regalo'])."','".$fecha_log."','".$_POST['regalo']."')";
$enviar2 = "UPDATE usuarios_placas SET username='".$user_perfil1."', code_placa='".$_POST['regalo']."' WHERE (username='".$usuario_activo."') AND (code_placa='".$_POST['regalo']."')";

if ($link->query($enviar1)) { 
if ($link->query($enviar2)) {
  
// Guardar acción en Logs si se ha iniciado sesión

$accion = " $lang[115] $columnas[username]";
$enviar_log = "INSERT INTO logs (usuario,accion,fecha) values ('".$usuario_activo."','".$accion."','".$fecha_log."')";
$link->query($enviar_log);
// Log guardado en Base de datos
  
echo "<div class='alert alerta-si alert-dismissible'><button type='button' class='close' data-dismiss='alert'>×</button>$lang[113] $user_perfil1 $lang[71]</div>";

	  }}}}else {
	echo "<div class='alert alerta-no alert-dismissible'><button type='button' class='close' data-dismiss='alert'>×</button>$lang[114]</div>";
}
  }
					}
					}
?>
  
							<table class="table table-bordered">
							<tr>
								<td>
									<?php echo $lang[27]; ?>:
								</td>
								<td>
									<?php echo $columnas['username']; ?>
								</td>
							</tr>
							<?php if("$columnas[mostraremail]"=="Si"){?>
							<tr>
								<td>
									<?php echo $lang[50]; ?>:
								</td>
								<td>
									<?php echo $columnas['email']; ?>
								</td>
								<tr>
									<?php
									}
									?>
									<tr>
										<td>
											<?php echo $lang[119]; ?>:
										</td>
										<td>
											<?php echo $columnas['fecha']; ?>
										</td>
									</tr>
										<tr>
											<tr>
												<td>
													<?php echo $lang[122]; ?>:
												</td>
												<td>
													<?php 
													switch($columnas['rank']) {
														case 2:
															echo 'Seguridad';
															break;
														case 3:
															echo 'Entrenador';
															break;
														case 4:
															echo 'Logística';
															break;
														case 5:
															echo 'Supervisor';
															break;
														case 6:
															echo 'Director';
															break;
														case 7:
															echo 'Presidente';
															break;
														case 8:
															echo 'Operativo';
															break;
														case 9:
															echo 'Junta Directiva';
															break;
														case 10:
															echo 'Administración';
															break;
														case 11:
															echo 'Mánager';
															break;
														case 12:
															echo 'Founder';
															break;															
														default:
															echo 'Rango Desconocido';
													}
													?>
												</td>
												</tr>

												<tr>
												<td>
													<?php echo "Misión"; ?>:
												</td>
												<td>
												<?php echo $columnas['motto']; ?>
												</td>
												</tr>

												<tr>
												<td>
													<?php echo "Firma"; ?>:
												</td>
												<td>
												<?php echo $columnas['TAG']; ?>
												</td>
												</tr>
												
												<tr>
												<td>
													<?php echo "Ascenido por"; ?>:
												</td>
												<td>
												<?php echo $columnas['AP']; ?>
												</td>
												</tr>	
												<tr>
													<?php					
														$fechaup = new DateTime($columnas['uc']); // Fecha guardada en la base de datos
														$fechaActual = new DateTime(); // Fecha y hora actual

														// Calcular la diferencia
														$diferencia = $fechaActual->diff($fechaup);

														// Construir el texto con la diferencia de tiempo
														$diferenciaTexto = "Hace " . $diferencia->days . " días, " . $diferencia->h . " horas, " . $diferencia->i . " minutos, " . $diferencia->s . " segundos";
													?>

													<td>
														<?php echo "Última vez conectado"; ?>:
													</td>
													<td>
														<?php echo $diferenciaTexto; ?>
													</td>
												</tr>

												<tr>
													<?php if("$columnas[mostrarnombreapellido]"=="Si"){?>
													<tr>
														<td>
															<?php echo $lang[123]; ?>:
														</td>
														<td>
															<?php echo $columnas['nombre']; ?>
														</td>
														</tr>
														<tr>
															<tr>
																<td>
																	<?php echo $lang[124]; ?>:
																</td>
																<td>
																	<?php echo $columnas['apellido']; ?>
																</td>
																<tr>
																	<?php
																	}
																	?>
																	<?php if("$columnas[mostrarpais]"=="Si"){?>
																	<tr>
																		<td>
																			<?php echo $lang[125]; ?>:
																		</td>
																		<td>
																			<?php echo $columnas['pais']; ?>
																		</td>
																		<tr>
																			<?php
																			}
																			?>
																			</table>
																		</div>
																	</div>
																</div>
															</div>
															
															<div id="placas" class="panel panel-default">
																<div class="panel-heading orange">
																	<h3 class="panel-title"><?php echo $lang[126]; ?> <?php echo $columnas['username']; ?></h3>
																</div>
																<div class="panel-body">
																<div style="margin:10px;">
																<?php 
																$user_perfil = $columnas['username'];
																$resultado2 = $link->query("SELECT * FROM usuarios_placas WHERE username = '".$user_perfil."'");
																while($row = mysqli_fetch_array($resultado2)){
																	$placa_user = $row['code_placa'];

																$resultado1 = $link->query("SELECT * FROM placas WHERE code = '".$placa_user."'");
																while($row=mysqli_fetch_array($resultado1)){
																	$code = $row['code'];
																	$imagen_placa = $row['imagen'];
																	?>
																	
						<div data-toggle="tooltip" title="<?php echo $code; ?>
							" class="badgehabbink">
							<div class="iconbadge">
								<img src="<?php echo $imagen_placa; ?>" alt="" style="padding:7px;">
							</div>
						</div>
						
																<?php
																}}
																			$result = $link->query("SELECT * FROM usuarios_placas WHERE username = '".$user_perfil."'");
																			$row_cnt = mysqli_num_rows($result);
																			if($row_cnt == 0){?>
																		 <div class='alert alerta-no alert-dismissible'><button type='button' class='close' data-dismiss='alert'>×</button><?php echo $user_perfil; ?> <?php echo $lang[127]; ?></div>
																			<?php } ?>
																
						<script>
                                        $(document).ready(function() {
                                            $('[data-toggle="tooltip"]').tooltip();
                                        });
                                    </script>
</div>
																</div>
															</div>														
															
															</center>
														</div>
														<div class="col-md-4">
														<?php echo $cartel_radio; ?>
                              <?php echo $redes_sociales; ?>
															<?php echo $cartel_publicidad; ?>
														</div>
													</div>
												</div>