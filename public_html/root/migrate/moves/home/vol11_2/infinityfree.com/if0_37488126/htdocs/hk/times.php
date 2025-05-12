<?php
include "../Templates/Hk_Head.php";

// Validar permisos del usuario actual
$query = $link->query("SELECT username, rank, dev, TAG, rank_pbl FROM usuarios WHERE username = '" . $username . "'");
$row = mysqli_fetch_array($query);
$dev = $row['dev'];
$rank_pbl = $row['rank_pbl'];
$rangouser = $row['rank'];
if (!($dev == 1 || $rank_pbl == 1) && ($rangouser >= 1 && $rangouser <= 8)) {
  echo '<script>window.location.href="index.php";</script>';
  exit;
}

include "../Templates/Hk_Nav.php";
?>

<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap4.min.css">

<div class="container">
  <div class="row">
    <div class="panel panel-default">
      <div class="panel-heading blue" style="display: flex; justify-content: space-between; align-items: center;">
        <h3 class="panel-title">Participantes en el Sorteo</h3>
      </div>
      <div class="panel-body">
        <table class="table table-striped table-hover" id="userTable">
          <thead>
            <tr>
              <th>Usuario</th>
              <th>Tiempo Total</th>
              <th>Encargado</th>
              <th>Acciones</th>
            </tr>
          </thead>
          <tbody></tbody>
        </table>
      </div>

      <?php if ($dev == 1): ?>
        <div class="row mt-4">
          <div class="col-md-12 text-center" style="padding: 20px;">
            <button class="btn btn-danger" id="reset-all">Limpiar tiempos</button>
          </div>
        </div>
      <?php endif; ?>
    </div>
  </div>
</div>

<?php include "../Templates/Footer.php"; ?>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
  $(document).ready(function () {
    let intervalIds = {};
    let ultimaFechaMostrada = "";

    const tabla = $('#userTable').DataTable({
      ajax: "times/fetch_table_body.php",
      serverSide: false,
      responsive: true,
      ordering: true,
      paging: true,
      searching: true,
      language: {
        url: "//cdn.datatables.net/plug-ins/1.11.5/i18n/Spanish.json"
      },
      drawCallback: function () {
        loadTableState();
        actualizarContadoresDescendentes();
        bindBotonEventos();
      }
    });

    function loadTableState() {
      $('.timer').each(function () {
        const startTime = parseInt($(this).data('start-time'), 10);
        const username = $(this).data('username');
        if (!isNaN(startTime)) {
          if (intervalIds[username]) clearInterval(intervalIds[username]);
          intervalIds[username] = setInterval(() => {
            const elapsed = Math.floor(Date.now() / 1000) - startTime;
            const h = Math.floor(elapsed / 3600).toString().padStart(2, '0');
            const m = Math.floor((elapsed % 3600) / 60).toString().padStart(2, '0');
            const s = (elapsed % 60).toString().padStart(2, '0');
            $(this).text(`${h}:${m}:${s}`);
          }, 1000);
        }
      });
    }

    function actualizarContadoresDescendentes() {
      document.querySelectorAll('.timer-descendente').forEach(contador => {
        let tiempoRestante = parseInt(contador.dataset.tiempoRestante);
        const username = contador.dataset.username;
        if (tiempoRestante > 0) {
          tiempoRestante--;
          contador.dataset.tiempoRestante = tiempoRestante;
          const m = Math.floor(tiempoRestante / 60).toString().padStart(2, '0');
          const s = (tiempoRestante % 60).toString().padStart(2, '0');
          contador.textContent = `${m}:${s}`;
        } else {
          contador.textContent = '00:00';
          cambiarBotonReanudarAIniciar(username);

          // Recargar la tabla para ese usuario
          tabla.ajax.reload(null, false); // Esto recarga todo, pero es seguro y actualiza “tiempo total”
        }
      });
    }

    function cambiarBotonReanudarAIniciar(username) {
      const boton = document.querySelector(`.resume-time[data-username="${username}"]`);
      if (!boton) return;
      const fila = boton.closest('tr');
      fila.querySelector('td:nth-child(2)').textContent = '00:00:00';
      fila.querySelector('td:nth-child(3)').textContent = '-';

      const nuevoBoton = document.createElement('button');
      nuevoBoton.className = 'btn btn-success btn-sm start-time';
      nuevoBoton.textContent = 'Iniciar';
      nuevoBoton.dataset.username = username;

      boton.replaceWith(nuevoBoton);
      bindBotonEventos();
    }

    function bindBotonEventos() {
      $('.start-time').off().on('click', function () {
        const username = $(this).data('username');
        const encargado = "<?php echo $_SESSION['username']; ?>";
        $.post('times/start_time.php', { username, encargado }, function () {
          tabla.ajax.reload(null, false);
        });
      });

      $('.pause-time').off().on('click', function () {
        const username = $(this).data('username');
        $.post('times/pause_time.php', { username }, function () {
          tabla.ajax.reload(null, false);
        });
      });

      $('.resume-time').off().on('click', function () {
        const username = $(this).data('username');
        $.post('times/resume_time.php', { username }, function () {
          tabla.ajax.reload(null, false);
        });
      });

      $('.stop-time').off().on('click', function () {
        const username = $(this).data('username');
        $.post('times/stop_time.php', { username }, function () {
          tabla.ajax.reload(null, false);
        });
      });

      $('.afk-time').off().on('click', function () {
        const username = $(this).data('username');
        $.post('times/afk_time.php', { username }, function () {
          tabla.ajax.reload(null, false);
        });
      });

    }

    function verificarNuevaAccion() {
      $.getJSON('times/get_ultima_accion.php', function (data) {
        if (data.fecha !== ultimaFechaMostrada) {
          ultimaFechaMostrada = data.fecha;
          Swal.fire({
            toast: true,
            position: 'top-end',
            icon: 'info',
            title: `${data.usuario} ${data.accion}`,
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true
          });
        }
      });
    }

    // Evento para limpiar todos los tiempos (botón de administrador)
    $('#reset-all').on('click', function () {
      Swal.fire({
        title: '¿Estás seguro?',
        text: 'Esto eliminará todos los tiempos de los usuarios.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Sí, reiniciar',
        cancelButtonText: 'Cancelar'
      }).then((result) => {
        if (result.isConfirmed) {
          $.post('times/reset-all.php', {}, function () {
            Swal.fire({
              icon: 'success',
              title: 'Reiniciado',
              text: 'Se han reiniciado todos los tiempos.',
              timer: 2000,
              showConfirmButton: false
            });
            tabla.ajax.reload(null, false);
          }).fail(() => {
            Swal.fire({
              icon: 'error',
              title: 'Error',
              text: 'No se pudieron reiniciar los tiempos.'
            });
          });
        }
      });
    });

    // Intervalos de actualización automática
    setInterval(() => tabla.ajax.reload(null, false), 3000);
    setInterval(actualizarContadoresDescendentes, 1000);
    setInterval(verificarNuevaAccion, 3000);
  });
</script>