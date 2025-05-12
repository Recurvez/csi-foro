<?php
include "../Templates/Hk_Head.php";

// Obtener el rango y el TAG del usuario actual
$query = $link->query('SELECT rank, dev, TAG FROM usuarios WHERE username = "' . $username . '"');
while ($row = mysqli_fetch_array($query)) {
    $rangouser = $row['rank'];
    $dev = $row['dev'];
    $tag = $row['TAG'];

    // Si el usuario tiene 'dev == 1', lo dejamos pasar sin restricciones.
    if ($dev == 1) {
        break; // O puedes hacer otro proceso si es necesario.
    }

    // Si 'dev != 1', entonces miramos el rango del usuario.
    if ($rangouser >= 1 && $rangouser <= 9) {
        header("Location: " . $_SERVER['HTTP_REFERER']); // Redirigir a la página anterior
        exit; // Salir del script después de la redirección
    }
}

include "../Templates/Hk_Nav.php";
?>

<!-- Agregar enlaces para CSS y JavaScript de DataTables -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap4.min.css">

<div class="container">
    <div class="row">
        <div class="panel panel-default">
            <div class="panel-heading blue"
                style="display: grid; grid-template-columns: 1fr auto; align-items: center; position: relative;">
                <h3 class="panel-title"><?php echo 'Registro de Ascensos'; ?></h3>
            </div>
            <div class="panel-body">
                <table class="table table-striped table-hover" id="userTable"> <!-- Agregar clases Bootstrap -->

                    <thead>
                        <tr>
                            <th><?php echo $lang[27]; ?></th>
                            <th><?php echo 'Motivo'; ?></th>
                            <th><?php echo 'Acciones'; ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $resultado = $link->query("SELECT * FROM venta_vip $whereClause ORDER BY id DESC");
                        while ($row = mysqli_fetch_array($resultado)) {

                            ?>
                            <tr>
                                <td><?php echo $row['usuario']; ?></td>
                                <td><?php echo $row['motivo']; ?></td>
                                <td>
                                    <a href="eliminar/vip.php?id=<?php echo $row['id']; ?>">
                                        <button type="button" class="btn btn-sm btn-danger">
                                            <span class="MPicon-cross"></span>
                                        </button>
                                    </a>
                                </td>
                            </tr>
                            <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div style="width: 500px" class="panel panel-default">
            <div class="panel-heading green">
                <h3 class="panel-title"><?php echo 'Venta VIP'; ?></h3>
            </div>
            <div class="panel-body">
                <div style="float:left;margin:10px;height: auto;display: block;">
                    <form action="" method="post" enctype="multipart/form-data">
                        <div style="float:left;margin-left:10px;">
                            <label><?php echo $lang[27]; ?></label>
                            <input style="margin-bottom: 10px;width:200px;" type="text" required="" class="form-control"
                                name="user" placeholder="<?php echo $lang[175]; ?>" value="" />
                        </div>

                        <div style="float:left;margin-left:10px;">
                            <label><?php echo 'Motivo'; ?></label>
                            <select style="margin-bottom: 10px;width:200px;" class="form-control" name="motivo"
                                required>
                                <option value="Venta">Venta</option>
                                <option value="Alianza">Alianza</option>
                                <option value="Rango Administrativo">Rango Administrativo</option>
                            </select>
                        </div>

                        <br style="clear: both;" />

                        <div style="float:left;margin-left:10px; width: 100%;">
                            <input class="btn btn-primary" name="guardar" type="submit"
                                value="<?php echo $lang[325]; ?>" style="width: 120px;margin-top: 10px;" />
                        </div>
                    </form>

                    <?php
                    if ($_POST['guardar'] && $_POST['user']) {
                        $user = $_POST['user'];
                        $motivo = $_POST['motivo'];
                        $fechaActual = date('Y-m-d H:i:s');

                        // Verificación si el usuario ya existe
                        $checkQuery = "SELECT * FROM venta_vip WHERE usuario = '$user'";
                        $checkResult = $link->query($checkQuery);

                        if ($checkResult->num_rows > 0) {
                            // Si el usuario ya existe
                            echo "<script>
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'El usuario ya está registrado.',
            confirmButtonText: 'OK'
        });
        </script>";
                        } else {
                            // Si el usuario no existe, procede a insertar
                            $enviar = "INSERT INTO venta_vip (usuario, motivo) VALUES ('$user', '$motivo')";
                            if ($link->query($enviar)) {
                                // Guardar acción en Logs si el motivo es "Venta"
                                if ($motivo === 'Venta') {
                                    $fecha_log = $fechaActual;
                                    $accion = "Ha vendido VIP al usuario <strong><u>$user</u></strong>.";
                                    $enviar_log = "INSERT INTO logs_ventas (usuario, accion, fecha) VALUES ('" . $username . "', '" . $accion . "', '" . $fecha_log . "')";
                                    $link->query($enviar_log);
                                }

                                echo "<script>
            Swal.fire({
                icon: 'success',
                title: '¡Éxito!',
                text: 'El usuario se ha registrado correctamente.',
                confirmButtonText: 'OK'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = 'venta_vip.php';
                }
            });
            </script>";
                            } else {
                                echo "Error: " . $link->error;
                            }
                        }
                    }

                    ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Agregar scripts de DataTables y activar DataTables en la tabla -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap4.min.js"></script>

<script>
    $(document).ready(function () {
        $('#userTable').DataTable({
            "paging": true,
            "searching": true,
            "ordering": true,
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.11.5/i18n/Spanish.json" // Traducción al español
            }
        });

        $('#userInput').on('keyup', function () {
            let search = $(this).val();
            if (search.length > 2) {
                $.ajax({
                    url: '../kernel/ajax/buscar_usuarios.php',
                    method: 'GET',
                    data: { search: search },
                    success: function (data) {
                        let suggestions = JSON.parse(data);
                        let suggestionList = $('#suggestions');

                        suggestionList.empty();
                        if (suggestions.length > 0) {
                            suggestions.forEach(function (user) {
                                suggestionList.append('<li class="suggestion-item">' + user + '</li>');
                            });
                            suggestionList.show();
                        } else {
                            suggestionList.hide();
                        }
                    }
                });
            } else {
                $('#suggestions').hide();
            }
        });

        $(document).on('click', '.suggestion-item', function () {
            $('#userInput').val($(this).text());
            $('#suggestions').hide();
        });
    });
</script>

<?php include "../Templates/Footer.php"; ?>