<?php
include "../Templates/Hk_Head.php";

session_start();
$username = $_SESSION['username'] ?? null;

if (!$username) {
    header("Location: login.php");
    exit;
}

$query = $link->query("SELECT username, rank, dev, TAG, rank_pbl FROM usuarios WHERE username = '$username'");
$row = mysqli_fetch_assoc($query);
$dev = $row['dev'];
$rank_pbl = $row['rank_pbl'];
$rangouser = $row['rank'];

$isAllowed = $dev == 1 || $rank_pbl == 1;
$hasRank = $rangouser >= 1 && $rangouser <= 8;

if (!$isAllowed && $hasRank) {
    header("Location: index.php");
    exit;
}

include "../Templates/Hk_Nav.php";
?>

<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<div class="container mt-4">
    <h3>Control de Tiempos</h3>
    <div id="mensaje" class="my-2"></div>
    <table id="tablaUsuarios" class="table table-bordered">
        <thead>
            <tr>
                <th>Usuario</th>
                <th>Estado</th>
                <th>Encargado</th>
                <th>Tiempo Restante</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody id="cuerpoTabla">
            <!-- Se llenará por AJAX -->
        </tbody>
    </table>
</div>

<script>
setInterval(cargarTabla, 10000); // Recargar cada 10 segundos
cargarTabla(); // Cargar al inicio

function accionTiempo(accion, username) {
    $.post(`times/${accion}_time.php`, { username: username }, function (data) {
        $('#mensaje').html(`<div class="alert alert-info">${data}</div>`);
        cargarTabla();
    });
}

function iniciarTemporizadores() {
    $('.temporizador').each(function () {
        const span = $(this);
        const estado = span.data('estado');
        let restante = parseInt(span.data('restante'));

        if (estado === 'activo' || estado === 'reanudado') {
            const id = span.attr('id');

            if (!window[`interval_${id}`]) {
                window[`interval_${id}`] = setInterval(() => {
                    if (restante > 0) {
                        restante--;
                        span.text(restante + 's');
                    } else {
                        clearInterval(window[`interval_${id}`]);
                        span.text('¡Finalizó!');
                        span.css('color', 'red');

                        // OPCIONAL: detener automáticamente en el servidor
                        /*
                        const username = id.replace('timer-', '');
                        $.post(`times/stop_time.php`, { username: username }, function (data) {
                            console.log(data);
                            cargarTabla(); // Refrescar estado
                        });
                        */
                    }
                }, 1000);
            }
        }
    });
}

// Ejecutar después de cada carga AJAX
function cargarTabla() {
    $('#cuerpoTabla').load('times/fetch_table_body.php', iniciarTemporizadores);
}
</script>
