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
        break;
    }

    // Si 'dev != 1', entonces miramos el rango del usuario.
    if ($rangouser >= 1 && $rangouser <= 10) {
        echo '<script>window.location.href="index.php";</script>';
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
                <h3 class="panel-title"><?php echo $lang[6]; ?></h3>
            </div>

            <div class="panel-body">

                <?php if ($rangouser > 10 || $dev == 1) { ?>
                    <div style="border-bottom: #ddd solid 1px; padding: 0px 0px 10px 15px;">
                        <a href="eliminar/pagas.php">
                            <button type="button" class="btn btn-sm btn-danger"><?php echo 'Reiniciar Lista'; ?></button>
                        </a>
                    </div>
                <?php } ?>

                <table class="table table-striped table-hover" id="userTable" style="user-select:text;">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th><?php echo $lang[27]; ?></th>
                            <th>Minutos</th>
                            <th>Cantidad a pagar</th>
                            <th>Pagado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $resultado = $link->query("SELECT p.id, p.usuario, p.mins, p.pagado, u.rank 
                        FROM pagas p 
                        LEFT JOIN usuarios u ON p.usuario = u.username 
                        WHERE p.id > 0 ORDER BY p.id ASC");
                        while ($row = mysqli_fetch_array($resultado)) {
                            $mins = $row['mins'];
                            $rank = $row['rank'];

                            // Calcular la cantidad a pagar
                            if ($rank == 2 && $mins >= 360) {
                                $pago_total = ($mins / 360) + 2;
                            } elseif (($rank == 3 || $rank == 4) && $mins >= 360) {
                                $pago_total = ($mins / 360) + 3;
                            } elseif (($rank == 5 || $rank == 6) && $mins >= 360) {
                                $pago_total = ($mins / 360) + 4;
                            } elseif (($rank == 7 || $rank == 8) && $mins >= 360) {
                                $pago_total = ($mins / 360) + 5;
                            } elseif ($rank == 9 && $mins >= 360) {
                                $pago_total = ($mins / 360) + 6;
                            } else {
                                $pago_total = 1; // Default si el rango no está definido
                            }

                            // Regla de redondeo especial
                            $parte_decimal = $pago_total - floor($pago_total);
                            if ($parte_decimal >= 0.65) {
                                $pagar = ceil($pago_total); // Redondear hacia arriba si la parte decimal es >= 0.8
                            } else {
                                $pagar = floor($pago_total); // Redondear hacia abajo si la parte decimal es < 0.8
                            }


                            ?>
                            <tr>
                                <td><?php echo $row['id']; ?></td>
                                <td><?php echo $row['usuario']; ?></td>
                                <td><?php echo $mins; ?></td>
                                <td><?php echo $pagar; ?> créditos</td>
                                <td>
                                    <?php
                                    echo $row['pagado'] == 1 ? 'Sí' : 'No';
                                    ?>
                                </td>
                                <td>
                                    <?php
                                    if ($row['pagado'] == 1) {
                                        ?>
                                        <a href="actualizar/pagas.php?id=<?php echo $row['id']; ?>">
                                            <button type="button" class="btn btn-sm btn-warning">
                                                <span class="MPicon-cross"></span>
                                            </button>
                                        </a>
                                        <?php
                                    } ?>
                                    <a href="eliminar/pagas.php?id=<?php echo $row['id']; ?>">
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
                <?php if ($rangouser > 10 || $dev == 1) { ?>
                    <a href="cerrar_semana.php">
                        <button type="submit" class="btn btn-primary">Cerrar Semana</button>
                    </a>
                <?php } ?>
            </div>
        </div>
        <div style="width: 500px" class="panel panel-default">
            <div class="panel-heading green">
                <h3 class="panel-title"><?php echo $lang[437]; ?></h3>
            </div>
            <div class="panel-body">
                <div style="float:left;margin:10px;height: auto;display: block;">
                    <form action="" method="post" enctype="multipart/form-data">
                        <div style="float:left;margin-left:10px;">
                            <label><?php echo $lang[27]; ?></label>
                            <input style="margin-bottom: 10px;width:200px;" type="text" required="" class="form-control"
                                name="user" id="userInput" placeholder="<?php echo $lang[175]; ?>" value="" />

                            <!-- Estilos aplicados directamente en el desplegable -->
                            <ul id="suggestions"
                                style="list-style-type: none; margin: 0; padding: 5px; background-color: #f8f9fa; border: 1px solid #ddd; max-height: 150px; overflow-y: auto; width: 200px; position: absolute; z-index: 1000; display: none; border-radius: 4px; box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);">
                                <!-- Las sugerencias aparecerán aquí -->
                            </ul>
                        </div>

                        <div style="float:left;margin-left:10px;">
                            <label><?php echo 'Minutos'; ?></label>
                            <input style="margin-bottom: 10px;width:200px;" type="text" required="" class="form-control"
                                name="mins" placeholder="<?php echo 'Minutos'; ?>" value="" />
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
                        $mins = $_POST['mins'];
                        ;

                        // Actualización en la base de datos
                        $enviar = "INSERT INTO pagas (usuario, mins) VALUES ('$user', '$mins')";
                        if ($link->query($enviar)) {

                            // Guardar acción en Logs si se ha iniciado sesión
                            $fecha_log = $fechaActual;
                            $accion = "Ha anotado al usuario <strong><u>$user</u></strong> a la lista de pagas.";
                            $enviar_log = "INSERT INTO logs (usuario,accion,fecha) values ('" . $username . "','" . $accion . "','" . $fecha_log . "')";
                            $resultado_log = $link->query($enviar_log);

                            echo "<script>
                                Swal.fire({
                                    icon: 'success',
                                    title: '¡Éxito!',
                                    text: 'El usuario se ha registrado correctamente.',
                                    confirmButtonText: 'OK'
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        window.location.href = 'pagas2.php';
                                    }
                                });
                                </script>";

                            // Log guardado en Base de datos
                        } else {
                            echo "Error: " . $link->error;
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
                "decimal": "",
                "emptyTable": "No hay datos disponibles en la tabla",
                "info": "Mostrando _START_ a _END_ de _TOTAL_ registros",
                "infoEmpty": "Mostrando 0 a 0 de 0 registros",
                "infoFiltered": "(filtrado de _MAX_ registros totales)",
                "lengthMenu": "Mostrar _MENU_ registros",
                "loadingRecords": "Cargando...",
                "processing": "Procesando...",
                "search": "Buscar:",
                "zeroRecords": "No se encontraron registros coincidentes",
                "paginate": {
                    "first": "Primero",
                    "last": "Último",
                    "next": "Siguiente",
                    "previous": "Anterior"
                },
                "aria": {
                    "sortAscending": ": activar para ordenar la columna de manera ascendente",
                    "sortDescending": ": activar para ordenar la columna de manera descendente"
                }
            },
            "order": [[0, "asc"]]
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