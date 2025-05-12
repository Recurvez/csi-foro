<?php
include "../Templates/Hk_Head.php";

// Obtener el rango y el TAG del usuario actual
$query = $link->query('SELECT username, rank, dev, TAG, rank_pbl FROM usuarios WHERE username = "' . $username . '"');
while ($row = mysqli_fetch_array($query)) {
    $usernamee = $row['username'];
    $rangouser = $row['rank'];
    $dev = $row['dev'];
    $tag = $row['TAG'];
    $rank_pbl = $row['rank_pbl'];

    // Permitir acceso si el usuario tiene 'dev == 1'
    if ($dev == 1 || $rank_pbl == 1) {
        break;
    }

    // Limitar el acceso para ciertos rangos de usuarios
    if ($rangouser >= 1 && $rangouser <= 12) {
        echo '<script>window.location.href="index.php";</script>';
        exit;
    }
}

include "../Templates/Hk_Nav.php";
?>

<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap4.min.css">

<div class="container">
    <div class="row">
        <!-- Participantes en el sorteo -->
        <div class="panel panel-default">
            <div class="panel-heading blue" style="display: grid; grid-template-columns: 1fr auto; align-items: center; position: relative;">
                <h3 class="panel-title"><?php echo 'Participantes en el Sorteo'; ?></h3>
            </div>
            <div class="panel-body">
                <table class="table table-striped table-hover" id="userTable" style="user-select:text;">
                    <thead>
                        <tr>
                            <th><?php echo 'Usuario'; ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $resultado = $link->query("SELECT username FROM usuarios WHERE rank >= 2 AND rank <= 9 AND participa_sorteo=1 ORDER BY username ASC");
                        while ($row = mysqli_fetch_array($resultado)) {
                        ?>
                        <tr>
                            <td><?php echo $row['username']; ?></td>
                        </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Botones para seleccionar ganadores y reiniciar el sorteo -->
    <div class="row mt-4">
        <div class="col-md-12 text-center">
            <button class="btn btn-primary" id="selectWinners">Seleccionar Ganadores</button>
            <button class="btn btn-danger" id="resetParticipants">Reiniciar Participación</button>
        </div>
    </div>

    <!-- Mostrar ganadores seleccionados -->
    <div class="row mt-4" id="winnersContainer" style="display: none;">
        <div class="panel panel-default">
            <div class="panel-heading green" style="padding: 15px; background-color: #28a745; color: #fff;">
                <h3 class="panel-title"><?php echo 'Ganadores del Sorteo'; ?></h3>
            </div>
            <div class="panel-body">
                <ul id="winnersList" class="list-group"></ul>
            </div>
        </div>
    </div>
</div>

<?php include "../Templates/Footer.php"; ?>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
$(document).ready(function() {
    $('#userTable').DataTable({
        "paging": true,
        "searching": true,
        "ordering": true,
        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.11.5/i18n/Spanish.json"
        }
    });

    // Botón para seleccionar ganadores
    $('#selectWinners').on('click', function() {
        $.ajax({
            url: '../kernel/ajax/select_winners.php',
            method: 'POST',
            success: function(response) {
                const winners = JSON.parse(response);
                $('#winnersList').empty();
                winners.forEach(function(winner) {
                    $('#winnersList').append('<li class="list-group-item">' + winner + '</li>');
                });
                $('#winnersContainer').show();
                Swal.fire({
                    title: '¡Ganadores seleccionados!',
                    text: 'Se han elegido 3 ganadores aleatorios.',
                    icon: 'success',
                    confirmButtonText: 'Aceptar'
                });
            },
            error: function() {
                Swal.fire({
                    title: 'Error',
                    text: 'Ocurrió un error al seleccionar los ganadores.',
                    icon: 'error',
                    confirmButtonText: 'Aceptar'
                });
            }
        });
    });

    // Botón para reiniciar participación
    $('#resetParticipants').on('click', function() {
        Swal.fire({
            title: '¿Estás seguro?',
            text: 'Esto eliminará la participación de todos los usuarios.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Sí, reiniciar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: '../kernel/ajax/reset_participants.php',
                    method: 'POST',
                    success: function() {
                        Swal.fire({
                            title: 'Reiniciado',
                            text: 'Se ha eliminado la participación de todos los usuarios.',
                            icon: 'success',
                            confirmButtonText: 'Aceptar'
                        });
                        //$('#userTable').DataTable().ajax.reload(); // Opcional si tienes recarga dinámica
                    },
                    error: function() {
                        Swal.fire({
                            title: 'Error',
                            text: 'No se pudo reiniciar la participación.',
                            icon: 'error',
                            confirmButtonText: 'Aceptar'
                        });
                    }
                });
            }
        });
    });
});
</script>
