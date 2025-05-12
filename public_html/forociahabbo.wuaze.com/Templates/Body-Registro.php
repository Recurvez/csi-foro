<?php
if($_SESSION["logeado"] == "SI"){
header ("Location: ../index?sessionerror");
exit;
}
$resultado = $link->query("SELECT * FROM config WHERE id = 1");
  while($row=mysqli_fetch_array($resultado))
  {
$registro_op = $row['registro'];
  }
  if("$registro_op" == "0"){
header ("Location: $url/index.php?registrobloqueado");
  }
?>
<div class="container">
	<div class="row">
		<div class="col-md-8">
			<center>
			<div class="registro page">
				<div class="panel panel-default">
					<div class="panel-heading green">
						<h3 class="panel-title" style="text-align: left;"><div class='contedor-badge'><div class='icon-users-new'></div></div> <?php echo $lang[48]; ?></h3>
					</div>
					<div class="panel-body">
						<div class="eventotext">
						<form class="form form-signup" role="form" method="post" action="kernel/login/insertar.php">
    <h5 class="colr bold mp" style="text-align: left;"><?php echo $lang[27]; ?></h5>
    <div class="form-group">
        <div class="input-group">
            <span class="input-group-addon"><span class="glyphicon glyphicon-user"></span></span>
            <input type="text" maxlength="50" class="form-control" required="true" name="username" id="username" placeholder="<?php echo $lang[49]; ?>"/>
        </div>
    </div>
    <h5 class="colr bold mp" style="text-align: left;"><?php echo $lang[50]; ?></h5>
    <div class="form-group">
        <div class="input-group">
            <span class="input-group-addon"><span class="glyphicon glyphicon-envelope"></span></span>
            <input name="email" type="email" id="email" required="true" class="form-control" placeholder="No pongas tu email personal"/>
        </div>
    </div>
    <h5 class="colr bold mp" style="text-align: left;"><?php echo $lang[28]; ?></h5>
    <div class="form-group">
        <div class="input-group">
            <span class="input-group-addon"><span class="glyphicon glyphicon-lock"></span></span>
            <input type="password" id="password" name="password" required="true" class="form-control" placeholder="No uses ninguna contraseña de carácter sensible"/>
        </div>
    </div>

    <!-- Aquí se integra Google reCAPTCHA -->
    <div class="g-recaptcha" data-sitekey="6Ld2LrAfAAAAALtTh-3esRTjdfIjnOMCox7Qd5fX"></div>

    <br>
    <input type="submit" name="Submit" value="<?php echo $lang[53]; ?>" class="btn btn-sm btn-primary btn-block loginbuttom">
</form>
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

	<script src="https://www.google.com/recaptcha/api.js" async defer></script>
	<!-- /container -->