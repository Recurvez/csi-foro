<?php
include "../Templates/Hk_Head.php";

// Obtener el rango y el TAG del usuario actual
$query = $link->query('SELECT rank, dev FROM usuarios WHERE username = "' . $username . '"');
while ($row = mysqli_fetch_array($query)) {
  $rangouser = $row['rank'];
  $dev = $row['dev'];

  // Si el usuario tiene 'dev == 1', lo dejamos pasar sin restricciones.
  if ($dev == 1) {
    // El usuario con dev == 1 tiene acceso, puedes poner la lógica que permita continuar aquí.
    break; // O puedes hacer otro proceso si es necesario.
  }

  // Si 'dev != 1', entonces miramos el rango del usuario.
  if ($rangouser >= 1 && $rangouser <= 10) {
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
        <h3 class="panel-title"><?php echo 'Logs Generales'; ?></h3>
      </div>
      <div class="panel-body">
        <table class="table table-striped table-hover" id="userTable"> <!-- Agregar clases Bootstrap -->

          <?php if ($rangouser > 12 || $dev == 1) { ?>
            <div style="border-bottom: #ddd solid 1px; padding: 0px 0px 10px 15px;">
              <a href="eliminar/logs.php">
                <button type="button" class="btn btn-sm btn-danger"><?php echo 'Eliminar Logs'; ?></button>
              </a>
            </div>
          <?php } ?>

          <thead>
            <tr>
              <th><?php echo $lang[27]; ?></th>
              <th><?php echo $lang[140]; ?></th>
              <th><?php echo $lang[415]; ?></th>
            </tr>
          </thead>
          <tbody>
            <?php
            $resultado = $link->query("SELECT * FROM logs $whereClause ORDER BY fecha DESC");
            while ($row = mysqli_fetch_array($resultado)) {
              // Convertir la fecha almacenada a un formato legible
              $fechaAccion = new DateTime($row['fecha']); // Asumiendo que 'fecha' es el nombre del campo
              $fechaActual = new DateTime();
              $diferencia = $fechaActual->diff($fechaAccion);

              // Calcular los segundos transcurridos desde la fecha de acción
              $segundosTranscurridos = $fechaActual->getTimestamp() - $fechaAccion->getTimestamp();

              // Definir el texto de diferencia de tiempo
              if ($segundosTranscurridos < 60) {
                $diferenciaTexto = "Recientemente";
              } else {
                $diferenciaTexto = "Hace " . $diferencia->days . " días, " . $diferencia->h . " horas, " . $diferencia->i . " minutos";
              }
              ?>
              <tr>
                <td><?php echo $row['usuario']; ?></td>
                <td><?php echo $row['accion']; ?></td>
                <td><?php echo $diferenciaTexto; ?></td> <!-- Aquí se muestra la diferencia en lugar de la fecha -->
              </tr>
              <?php
            }
            ?>
          </tbody>
        </table>
      </div>
    </div>

    <br>

    <div class="panel panel-default">
      <div class="panel-heading red"
        style="display: grid; grid-template-columns: 1fr auto; align-items: center; position: relative;">
        <h3 class="panel-title"><?php echo 'Logs Sospechosos'; ?></h3>
      </div>
      <div class="panel-body">
        <table class="table table-striped table-hover" id="userTable2"> <!-- Agregar clases Bootstrap -->

          <?php if ($rangouser > 12 || $dev == 1) { ?>
            <div style="border-bottom: #ddd solid 1px; padding: 0px 0px 10px 15px;">
              <a href="eliminar/logs_sospechosos.php">
                <button type="button" class="btn btn-sm btn-danger"><?php echo 'Eliminar Logs'; ?></button>
              </a>
            </div>
          <?php } ?>

          <thead>
            <tr>
              <th><?php echo $lang[27]; ?></th>
              <th><?php echo $lang[140]; ?></th>
              <th><?php echo $lang[415]; ?></th>
            </tr>
          </thead>
          <tbody>
            <?php
            $resultado = $link->query("SELECT * FROM logs_sospechosos $whereClause ORDER BY fecha DESC");
            while ($row = mysqli_fetch_array($resultado)) {
              // Convertir la fecha almacenada a un formato legible
              $fechaAccion = new DateTime($row['fecha']); // Asumiendo que 'fecha' es el nombre del campo
              $fechaActual = new DateTime();
              $diferencia = $fechaActual->diff($fechaAccion);

              // Calcular los segundos transcurridos desde la fecha de acción
              $segundosTranscurridos = $fechaActual->getTimestamp() - $fechaAccion->getTimestamp();

              // Definir el texto de diferencia de tiempo
              if ($segundosTranscurridos < 60) {
                $diferenciaTexto = "Recientemente";
              } else {
                $diferenciaTexto = "Hace " . $diferencia->days . " días, " . $diferencia->h . " horas, " . $diferencia->i . " minutos";
              }
              ?>
              <tr>
                <td><?php echo $row['user_logeado']; ?></td>
                <td><?php echo $row['accion']; ?></td>
                <td><?php echo $diferenciaTexto; ?></td> <!-- Aquí se muestra la diferencia en lugar de la fecha -->
              </tr>
              <?php
            }
            ?>
          </tbody>
        </table>
      </div>
    </div>

  </div>
</div><!-- /container -->

<!-- Agregar scripts de DataTables y activar DataTables en la tabla -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap4.min.js"></script>

<script>
  $(document).ready(function () {
    // Tabla de Logs Generales
    $('#userTable').DataTable({
      "paging": true,
      "searching": true,
      "ordering": true,
      "language": {
        "url": "//cdn.datatables.net/plug-ins/1.11.5/i18n/Spanish.json" // Traducción al español
      },
      "order": [[2, "asc"]],
      "columnDefs": [
        {
          "targets": 2, // La columna de diferencias de tiempo
          "type": "custom-date-order", // Personaliza el tipo de datos
        }
      ]
    });

    $(document).on('click', '.suggestion-item', function () {
      $('#userInput').val($(this).text());
      $('#suggestions').hide();
    });
  });

    $('#userTable2').DataTable({
      "paging": true,
      "searching": true,
      "ordering": true,
      "language": {
        "url": "//cdn.datatables.net/plug-ins/1.11.5/i18n/Spanish.json" // Traducción al español
      },
      "columnDefs": [
        {
          "targets": 2, // La columna de diferencias de tiempo
          "type": "custom-date-order", // Personaliza el tipo de datos
        }
      ]
    });

    $(document).on('click', '.suggestion-item', function () {
      $('#userInput').val($(this).text());
      $('#suggestions').hide();
    });

    // Define un tipo de orden personalizado para diferencias de tiempo
  $.fn.dataTable.ext.type.order['custom-date-order-pre'] = function (data) {
    // Convierte el texto de la columna (e.g., "Hace 2 días, 3 horas, 20 minutos") en un valor numérico para ordenación
    if (data === "Recientemente") {
      return 0; // Ordena "Recientemente" como lo más reciente
    }

    // Extrae días, horas, minutos del texto
    const match = data.match(/Hace (\d+) días, (\d+) horas, (\d+) minutos/);
    if (match) {
      const days = parseInt(match[1], 10);
      const hours = parseInt(match[2], 10);
      const minutes = parseInt(match[3], 10);
      // Convierte días, horas y minutos a una única métrica en minutos para comparar
      return days * 1440 + hours * 60 + minutes;
    }
    return Number.MAX_SAFE_INTEGER; // Si no coincide, lo pone al final
  };
</script>

<?php

include "../Templates/Footer.php";

?>