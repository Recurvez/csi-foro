<?php
$username = $_SESSION['username'] ?? null;

if (!$username) {
    echo "<div class='navbar-user-info'>Usuario no identificado.</div>";
    return;
}

$query = $link->query("SELECT estado, ini_time, tiempo_total_total FROM usuarios WHERE username = '$username'");
$row = $query->fetch_assoc();

$estado = $row['estado'];
$ini_time = $row['ini_time'];
$tiempo_total_total = (int)$row['tiempo_total_total'];

function calcularTiempoTranscurrido($fecha)
{
    $ahora = new DateTime();
    $fechaPasada = new DateTime($fecha);
    $diferencia = $ahora->diff($fechaPasada);

    $tiempoTranscurrido = '';
    if ($diferencia->h > 0) $tiempoTranscurrido .= $diferencia->h . 'h ';
    if ($diferencia->i > 0) $tiempoTranscurrido .= $diferencia->i . 'm ';
    if ($diferencia->s >= 0) $tiempoTranscurrido .= $diferencia->s . 's';

    return $tiempoTranscurrido ?: '0s';
}

function segundosAHorasMinutosSegundos($segundos)
{
    $horas = floor($segundos / 3600);
    $minutos = floor(($segundos % 3600) / 60);
    $segundos = $segundos % 60;
    return sprintf('%02d:%02d:%02d', $horas, $minutos, $segundos);
}
?>

<div class="navbar-user-info" style="padding: 8px 16px; font-size: 14px;">
    <i class="fa-solid fa-user-clock"></i> 
    <strong><?php echo ucfirst($estado); ?></strong> |
    <strong>Total:</strong> <?php echo segundosAHorasMinutosSegundos($tiempo_total_total); ?> |
    <strong>Actual:</strong> 
    <?php
    if (in_array($estado, ['activo', 'reanudado']) && $ini_time) {
        echo calcularTiempoTranscurrido($ini_time);
    } else {
        echo "—";
    }
    ?>
</div>
