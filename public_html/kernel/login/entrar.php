<?php
if(isset($_POST['username']) && !empty($_POST['username']) &&
   isset($_POST['password']) && !empty($_POST['password'])) {
    // Configura los datos de tu cuenta
    require ('../../global.php');

    if ($_POST['username']) {
        // Comprobación del envío del nombre de usuario y contraseña
        $username = htmlentities($_POST['username']);
        
        // Cifrado de la contraseña
        $cifrado5 = md5($_POST['password']);
        $cifrado4 = sha1($cifrado5);
        $cifrado3 = md5($cifrado4);
        $cifrado2 = sha1($cifrado3);
        $cifrado1 = md5($cifrado2);
        $password = md5($cifrado1);

        if ($password == NULL) {
            header("Location: ../../index.php?nopass");
            ?>
            <script type="text/javascript">
                location.href ="../../index.php?nopass";
            </script>
            <?php
            exit();
        } else {
            // Verificar si el usuario existe y si la contraseña coincide
            $query = $link->query("SELECT username, password, validacion, rank FROM usuarios WHERE username = '$username'") or die(mysqli_error());
            $data = mysqli_fetch_array($query);

            // Verificar si la contraseña es correcta
            if($data['password'] != $password) {
                header("Location: ../../index.php?errorpass");
                ?>
                <script type="text/javascript">
                    location.href ="../../index.php?errorpass";
                </script>
                <?php
                exit();
            } else {
                // Verificar si la cuenta ha sido validada
                if ($data['validacion'] != 1) {
                    header("Location: ../../index.php?notvalidated");
                    ?>
                    <script type="text/javascript">
                        location.href ="../../index.php?notvalidated";
                    </script>
                    <?php
                    exit();
                }

                // Inicio de sesión
                $_SESSION["username"] = $data['username'];
                $_SESSION["logeado"] = "SI";
                $rank = $data['rank']; // Obtener el rango del usuario

                // Recordar los datos si está marcado
                if(isset($_POST['recordar'])) {
                    $ip = getenv(REMOTE_ADDR);
                    $id_extreme = md5(uniqid(rand(), true));
                    $id_extreme2 = $username."%".$id_extreme."%".$ip;
                    setcookie('id_extreme', $id_extreme2, time() + 7776000, '/');
                    $link->query("UPDATE usuarios SET id_extreme='$id_extreme' WHERE username='$username'") or die(mysqli_error());
                }

                // Comprobar si la IP ha cambiado
                $resultado = $link->query("SELECT * FROM usuarios WHERE username = '$username'");
                $row = mysqli_fetch_array($resultado);
                $ip_original = $row['ip'];

                if ($ip_actual != $ip_original) {
                    // Guardar acción en Logs si se ha iniciado sesión con una IP diferente
                    $fecha_log = date("Y-m-d H:i:s");
                    $accion = "Ha iniciado sesión con otra IP (La cuenta no ha sido bloqueada) IP actual: $ip_actual , IP guardada: $ip_original";
                
                    // Insertar en logs_sospechosos
                    $enviar_log = "INSERT INTO logs_sospechosos (user_logeado, ip, accion, fecha) 
                                   VALUES ('$username', '$ip_actual', '$accion', '$fecha_log')";
                    $link->query($enviar_log);
                
                    // Actualizar la IP del usuario en la tabla usuarios
                    $enviarIp = "UPDATE usuarios SET ip = '$ip_actual' WHERE username = '$username'";
                    $link->query($enviarIp);
                }
                

                // Asignar placas según el rango del usuario
                for ($i = 1; $i <= $rank; $i++) {
                    // Consultar el código de la placa correspondiente al rango
                    $placa_query = $link->query("SELECT id, code FROM placas WHERE id = '$i'") or die(mysqli_error());
                    $placa_data = mysqli_fetch_array($placa_query);
                    $code_placa = $placa_data['code'];

                    // Comprobar si el usuario ya tiene la placa asignada
                    $placa_usuario_query = $link->query("SELECT * FROM usuarios_placas WHERE username = '$username' AND code_placa = '$code_placa'") or die(mysqli_error());
                    if (mysqli_num_rows($placa_usuario_query) == 0) {
                        // Si no tiene la placa, añadirla a usuarios_placas
                        $link->query("INSERT INTO usuarios_placas (username, code_placa) VALUES ('$username', '$code_placa')") or die(mysqli_error());
                    }
                }

                // Revisar y eliminar placas si el rango ha disminuido
                $placas_asignadas_query = $link->query("SELECT code_placa FROM usuarios_placas WHERE username = '$username'") or die(mysqli_error());
                while ($placa_asignada = mysqli_fetch_array($placas_asignadas_query)) {
                    // Obtener el id de la placa correspondiente
                    $placa_id_query = $link->query("SELECT id FROM placas WHERE code = '{$placa_asignada['code_placa']}'") or die(mysqli_error());
                    $placa_id_data = mysqli_fetch_array($placa_id_query);
                    $placa_id = $placa_id_data['id'];

                    // Si el ID de la placa es mayor que el rango del usuario, eliminar la placa
                    if ($placa_id > $rank) {
                        $link->query("DELETE FROM usuarios_placas WHERE username = '$username' AND code_placa = '{$placa_asignada['code_placa']}'") or die(mysqli_error());
                    }
                }

                // Guardar acción en Logs si se ha iniciado sesión
                $uc = date('Y-m-d H:i:s');
                $enviar_log = ("UPDATE usuarios SET uc='$uc' WHERE username='$username'") or die(mysqli_error());
                $resultado_log = $link->query($enviar_log);
                // Log guardado en Base de datos

                // Redirigir después de asignar o quitar placas
                header('Location: ../../index.php?iniciado');
                ?>
                <script type="text/javascript">
                    location.href ="../../index.php?iniciado";
                </script>
                <?php
            }
        }
    } else {
        header("Location: ../../index.php?no-completado");
        ?>
        <script type="text/javascript">
            location.href ="../../index.php?no-completado";
        </script>
        <?php
    }
}
?>
