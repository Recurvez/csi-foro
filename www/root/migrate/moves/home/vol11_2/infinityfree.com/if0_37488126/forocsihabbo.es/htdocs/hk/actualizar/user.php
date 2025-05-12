<?php 
require ('../../global.php');

// Verificar permisos del usuario
$query = $link->query('SELECT rank, dev FROM usuarios WHERE username = "' . $username . '"');
while ($row = mysqli_fetch_array($query)) {
    $rangouser = $row['rank'];
    $dev = $row['dev'];

    if ($dev == 1) {
        break;
    }

    if ($rangouser >= 1 && $rangouser <= 8) {
        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit;
    }
}

// Obtener datos enviados desde el formulario
$newusername = strip_tags($_POST['newusername']);
$newtag = strip_tags($_POST['newtag']);
$id = strip_tags($_POST['id']);
$week_worker = isset($_POST['week_worker']) ? intval($_POST['week_worker']) : 0;

// Verificar si el nuevo nombre de usuario o la nueva firma ya existen en la base de datos
$verificar_usuario = $link->query("SELECT * FROM usuarios WHERE username = '$newusername' AND id != '$id'");
// Verificar si el nuevo tag ya existe en la base de datos solo si newtag no está vacío
if (!empty($newtag)) {
    $verificar_tag = $link->query("SELECT * FROM usuarios WHERE TAG = '$newtag' AND id != '$id'");
} else {
    $verificar_tag = false; // Si newtag está vacío, no hay que comparar TAG
}

if ($verificar_usuario->num_rows > 0 || $verificar_tag->num_rows > 0) {
    header("Location: ../users.php?error=usuario_existente");
    exit;
} else {
    // Si "week_worker" está activado para este usuario, se desactiva en otros usuarios
    if ($week_worker == 1) {
        $link->query("UPDATE usuarios SET week_worker = 0 WHERE week_worker = 1");
    }

    // Actualizar datos del usuario
    $consulta = "
        UPDATE usuarios 
        SET 
            username = '$newusername', 
            tag = '$newtag', 
            avatar = 'https://www.habbo.es/habbo-imaging/avatarimage?size=m&direction=2&head_direction=2&user={$newusername}', 
            week_worker = '$week_worker' 
        WHERE 
            id = '$id'";
    $resultado = $link->query($consulta);

    if($week_worker == 0){
    // Guardar acción en los registros
    $fecha_log = date('Y-m-d H:i:s');
    $accion = "Ha editado los datos del usuario con ID $id, nombre actualizado a $newusername y firma a $newtag";
    $enviar_log = "INSERT INTO logs (usuario, accion, fecha) VALUES ('$username', '$accion', '$fecha_log')";
    $link->query($enviar_log);
    } else {
            // Guardar acción en los registros
    $fecha_log = date('Y-m-d H:i:s');
    $accion = "Ha puesto a $newusername como trabajador de la semana.";
    $enviar_log = "INSERT INTO logs (usuario, accion, fecha) VALUES ('$username', '$accion', '$fecha_log')";
    $link->query($enviar_log);
    }
    // Redirigir después de la actualización
    header("Location: ../users.php?success=actualizado");
    exit;
}
?>
