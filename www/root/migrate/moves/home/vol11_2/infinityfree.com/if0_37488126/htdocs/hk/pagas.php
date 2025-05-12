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
    if ($rangouser >= 1 && $rangouser <= 11) {
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
                            <th>Pagado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // Configuración de paginación
                        $elementos_por_pagina = 10; // Número de elementos por página
                        $pagina_actual = isset($_GET['pagina']) ? (int) $_GET['pagina'] : 1;
                        $inicio = ($pagina_actual - 1) * $elementos_por_pagina;
                        
                        // Obtener el total de usuarios
                        $total_resultados = $link->query("SELECT COUNT(*) AS total FROM pagas WHERE id > 0");
                        $total_row = mysqli_fetch_array($total_resultados);
                        $total_usuarios = $total_row['total'];
                        $total_paginas = ceil($total_usuarios / $elementos_por_pagina);
                        
                        // Consulta para obtener los usuarios en la página actual
                        $resultado = $link->query("SELECT * FROM pagas WHERE id > 0 ORDER BY id ASC LIMIT $inicio, $elementos_por_pagina");
                        while ($row = mysqli_fetch_array($resultado)) {
                            ?>
                            <tr>
                                <td><?php echo $row['id']; ?></td>
                                <td><?php echo $row['usuario']; ?></td>
                                <td>
                                    <?php
                                    echo $row['pagado'] == 1 ? 'Sí' : 'No';
                                    ?>
                                </td>
                                <td>
                                    <a href="actualizar/pagas.php?id=<?php echo $row['id']; ?>">
                                        <button type="button" class="btn btn-sm btn-success">
                                            <span class="MPicon-check"></span>
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
                <h3 class="panel-title"><?php echo $lang[437]; ?></h3>
            </div>
            <div class="panel-body">
                <div style="float:left;margin:10px;height: auto;display: block;">
                    <form action="" method="post" enctype="multipart/form-data">
                        <div style="float:left;margin-left:10px;">
                            <label><?php echo $lang[27]; ?></label>
                            <input style="margin-bottom: 10px;width:200px;" type="text" required="" class="form-control"
                                name="user" placeholder="<?php echo $lang[175]; ?>" value="" />
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
                        ;

                        // Actualización en la base de datos
                        $enviar = "INSERT INTO pagas (usuario) VALUES ('$user')";
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
                                        window.location.href = 'pagas.php';
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
$(document).ready(function() {
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
});
</script>

<?php include "../Templates/Footer.php"; ?>
