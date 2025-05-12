	  <div class="container">
     <div class="row">
        <div class="col-md-8">

		<center><div class="login">
	<div class="panel panel-default">
            <div class="panel-heading red">
              <h3 class="panel-title" style="text-align: left;"><div class='contedor-badge'><div class='icon-login'></div></div> <?php echo $lang[214]; ?></h3>
            </div>
            <div class="panel-body">

			<div class="eventotext">

<?
$id = htmlentities($_GET['id']);
$mail = htmlentities($_GET['mail']);
$contraseña_resultado = $_POST['contrasena'];

$cifrado5 = md5($_POST['contrasena']);
$cifrado4 = sha1($cifrado5);
$cifrado3 = md5($cifrado4);
$cifrado2 = sha1($cifrado3);
$cifrado1 = md5($cifrado2);
$contrasena = md5($cifrado1);

if($_POST['button']){
	if(isset($id) && isset($mail)){
		
		$queEmp = "SELECT * FROM usuarios WHERE email='$mail'";
		$resEmp = $link->query($queEmp, $conexion) or die(mysqli_error());
		$totEmp = mysqli_num_rows($resEmp);
		if($totEmp == 0){
		echo $lang[220];
		exit();
		}
		
		$row = mysqli_fetch_assoc($resEmp);
		$hash = md5(md5($row['username']).md5(sha1(md5(sha1(md5(md5($row['password'])))))));

        $guardarip = "UPDATE usuarios SET ip='$ip_actual' WHERE email='$mail'";
        $resultado_ip = $link->query($guardarip);
		
		if($hash == $id){
		$sql = "UPDATE usuarios SET password='".$contrasena."' WHERE email='$mail'";
		$link->query($sql,$conexion);
		echo "Contrase&ntilde;a a sido cambiada a: <b>$contraseña_resultado</b> $lang[221]";
		exit();			
		} else{
			echo '<div style="background-color:red;color:#fff;padding:10px;margin-bottom:10px;border-radius:5px;">'.$lang[222].'</div>';
		}
	}
}
?>
<form id="form1" name="form1" method="post" action="pass.php?id=<?php echo $id; ?>&mail=<?php echo $mail; ?>">
  <h5><?php echo $lang[223]; ?></h5><br />
  <input type="password" placeholder="<?php echo $lang[224]; ?>" class="form-control" name="contrasena" />
  <br />
<input type="submit" name="button" class="btn btn-primary" id="button" value="<?php echo $lang[225]; ?>" />
</form>

			</div>

            </div>
          </div>
		 </div></center>

		</div>
        <div class="col-md-4">

		<?php echo $cartel_radio; ?>

<?php echo $redes_sociales; ?>

<?php echo $cartel_publicidad; ?>

		</div>
      </div>

    </div> <!-- /container -->