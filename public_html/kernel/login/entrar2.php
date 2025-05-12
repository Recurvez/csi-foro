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
            header("Location: ../../mantenimiento.php?nopass");
            ?>
            <script type="text/javascript">
                location.href ="../../mantenimiento.php?nopass";
            </script>
            <?php
            exit();
        } else {
            // Verificar si el usuario existe y si la contraseña coincide
            $query = $link->query("SELECT username, password, validacion, rank FROM usuarios WHERE username = '$username'") or die(mysqli_error());
            $data = mysqli_fetch_array($query);

            // Verificar si la contraseña es correcta
            if($data['password'] != $password) {
                header("Location: ../../mantenimiento.php?errorpass");
                ?>
                <script type="text/javascript">
                    location.href ="../../mantenimiento.php?errorpass";
                </script>
                <?php
                exit();
            } else {
                // Verificar si la cuenta ha sido validada
                if ($data['validacion'] != 1) {
                    header("Location: ../../mantenimiento.php?notvalidated");
                    ?>
                    <script type="text/javascript">
                        location.href ="../../mantenimiento.php?notvalidated";
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
        header("Location: ../../mantenimiento.php?no-completado");
        ?>
        <script type="text/javascript">
            location.href ="../../mantenimiento.php?no-completado";
        </script>
        <?php
    }
}
?>
