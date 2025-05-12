<?php
include "../../global.php"; // incluye conexión BD y zona horaria

date_default_timezone_set("America/Los_Angeles");

$result = $link->query("SELECT username, estado, encargado, ini_time, tiempo_pausado FROM usuarios");

while ($row = mysqli_fetch_assoc($result)) {
    $username = $row['username'];
    $estado = $row['estado'];
    $encargado = $row['encargado'];
    $ini_time = $row['ini_time'];
    $tiempo_pausado = (int) $row['tiempo_pausado'];

    // Calcular tiempo restante solo si está activo o reanudado
    if (in_array($estado, ['activo', 'reanudado'])) {
        $inicio = strtotime($ini_time);
        $ahora = time();
        $transcurrido = $ahora - $inicio;
        $restante = max(0, $tiempo_pausado - $transcurrido);
    } elseif ($estado === 'pausado') {
        $restante = $tiempo_pausado;
    } else {
        $restante = 300; // valor por defecto
    }

    echo "<tr>";
    echo "<td>{$username}</td>";
    $estado_str = $estado === 'afk'
        ? "<span style='color: gray; font-style: italic;'>AFK</span>"
        : $estado;
    echo "<td>$estado_str</td>";

    echo "<td>{$encargado}</td>";
    echo "<td><span class='temporizador' data-estado='{$estado}' data-restante='{$restante}' id='timer-{$username}'>{$restante}s</span></td>";
    echo "<td>";

    switch ($estado) {
        case 'inactivo':
            echo "<button onclick=\"accionTiempo('start', '{$username}')\" class='btn btn-success btn-sm'>Iniciar</button>";
            break;
        case 'activo':
        case 'reanudado':
            echo "<button onclick=\"accionTiempo('pause', '{$username}')\" class='btn btn-warning btn-sm'>Pausar</button> ";
            echo "<button onclick=\"accionTiempo('stop', '{$username}')\" class='btn btn-danger btn-sm'>Finalizar</button>";
            break;
        case 'pausado':
            echo "<button onclick=\"accionTiempo('resume', '{$username}')\" class='btn btn-primary btn-sm'>Reanudar</button> ";
            echo "<button onclick=\"accionTiempo('stop', '{$username}')\" class='btn btn-danger btn-sm'>Finalizar</button>";
            break;
    }

    echo " <button onclick=\"accionTiempo('afk', '{$username}')\" class='btn btn-secondary btn-sm'>AFK</button>";
    echo "</td>";
    echo "</tr>";
}
?>