<?PHP
include "global/conexion.php";
if ($_POST) :
$user_id = $_POST['user_id'];
$noticia_id = $_POST['noticia_id'];
$comentario = $_POST['comentario'];

$comentario = trim($comentario);
$comentario = htmlentities($comentario);
$tabla = "comentarios";
//Asumiendo que ya tenemos una conexion a nuestra base de datos.
$consulta = mysql_query("INSERT INTO $tabla (user_id,noticia_id,comentario,fecha) VALUES('$user_id','$noticia_id','$comentario',NOW())");

if ($consulta) {
echo $user_id." dijo: <br> ".$comentario;
exit();
}

endif;
?>