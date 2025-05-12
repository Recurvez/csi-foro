<div class="container">
	<div class="row">
		<div class="col-md-12">
			<div class="panel panel-default">
				<div class="panel-heading blue">
					<h3 class="panel-title"><Center><?php echo $lang[54]; ?></center></h3>
				</div>
				<div class="panel-body">
					<div class="catalogo">
						<div id="loader" style="text-aling:center;margin-left:50%;">
							<img src="hk/loader.gif">
						</div>
						<CENTER>
						<div class="outer_div">
						</div></CENTER>
						<!-- Datos ajax Final -->
					</div>
				</div>
			</div>
		</div>
	</div>
	<script>
	$(document).ready(function(){
		load(1);
	});
	function load(page){
		var parametros = {"action":"ajax","page":page};
		$("#loader").fadeIn('slow');
		$.ajax({
			url:'kernel/ajax/Body_Placas_ajax.php',
			data: parametros,
			 beforeSend: function(objeto){
			$("#loader").html("<img src='hk/loader.gif'>");
			},
			success:function(data){
				$(".outer_div").html(data).fadeIn('slow');
				$("#loader").html("");
			}
		})
	}
	</script>
</div>
<!-- /container -->