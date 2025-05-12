<?php
session_start();

$resultado = $link->query("SELECT * FROM usuarios WHERE username = '$username'");
while ($row = mysqli_fetch_array($resultado)) {
    $ua = $row['ua'];
    $motto = $row['motto'];
    $estado = $row['estado'];
    $ini_time = $row['ini_time'];
    $tiempo_total = $row['tiempo_total'];
}

function calcularTiempoTranscurrido($fecha)
{
    $ahora = new DateTime();
    $fechaPasada = new DateTime($fecha);
    $diferencia = $ahora->diff($fechaPasada);

    $tiempoTranscurrido = '';
    if ($diferencia->y > 0) $tiempoTranscurrido .= $diferencia->y . ' año' . ($diferencia->y > 1 ? 's' : '') . ', ';
    if ($diferencia->m > 0) $tiempoTranscurrido .= $diferencia->m . ' mes' . ($diferencia->m > 1 ? 'es' : '') . ', ';
    if ($diferencia->d > 0) $tiempoTranscurrido .= $diferencia->d . ' día' . ($diferencia->d > 1 ? 's' : '') . ', ';
    if ($diferencia->h > 0) $tiempoTranscurrido .= $diferencia->h . ' hora' . ($diferencia->h > 1 ? 's' : '') . ', ';
    if ($diferencia->i > 0) $tiempoTranscurrido .= $diferencia->i . ' minuto' . ($diferencia->i > 1 ? 's' : '') . ', ';
    if ($diferencia->s > 0) $tiempoTranscurrido .= $diferencia->s . ' segundo' . ($diferencia->s > 1 ? 's' : '') . ', ';

    return rtrim($tiempoTranscurrido, ', ');
}

function segundosAHorasMinutosSegundos($segundos)
{
    $horas = floor($segundos / 3600);
    $minutos = floor(($segundos % 3600) / 60);
    $segundos = $segundos % 60;

    return sprintf('%02d:%02d:%02d', $horas, $minutos, $segundos);
}

// Solo calculamos los segundos si el usuario está activo
if ($estado === 'activo' && !empty($ini_time)) {
    $zonaUSA = new DateTimeZone('America/Los_Angeles'); // Puedes cambiar esto a tu zona exacta
    $fechaInicioCorr = new DateTime($ini_time, $zonaUSA);
    $ahora = new DateTime('now', $zonaUSA);
    $segundosTranscurridos = $ahora->getTimestamp() - $fechaInicioCorr->getTimestamp();
}



?>

<nav>
    <div class="nav-container">
        <div class="logo">
            <a href="#inicio"><img src="img/logocsi.png" alt="Logo CSI"></a>
        </div>
        <ul class="nav-links">
            <li><a href="#inicio">Inicio</a></li>
            <li><a href="#noticias">Noticias</a></li>
            <li><a href="#eventos">Eventos</a></li>
            <li><a href="#rangos">Rangos Oficiales</a></li>
            <li><a href="#equipo">Equipo</a></li>

            <?php if (isset($_SESSION["logeado"]) && $_SESSION["logeado"] === "SI") { ?>
                <li class="dropdown">
                    <img src="https://www.habbo.es/habbo-imaging/avatarimage?hb=img&size=b&headonly=1&user=<?php echo $username ?>" alt="Avatar" class="avatar">
                    <ul class="dropdown-menu">
                        <li><a href="/hk/index.php">Control Panel</a></li>
                        <li><a href="#" id="abrir-perfil-modal">Mi Perfil</a></li>
                        <li><a href="kernel/login/cerrar.php">Cerrar Sesión</a></li>
                    </ul>
                </li>
            <?php } else { ?>
                <li><a href="login.php">Login</a></li>
            <?php } ?>

            <li class="hidden"><a href="#footer">Footer</a></li>
        </ul>
        <div class="menu-toggle">
            <div class="bar"></div>
            <div class="bar"></div>
            <div class="bar"></div>
        </div>
    </div>
</nav>

<div id="perfil-modal" class="perfil-modal">
    <div class="perfil-modal-content">
        <span class="perfil-close">&times;</span>
        <h2>Mi Perfil</h2>
        <div class="perfil-info">
            <img src="https://www.habbo.es/habbo-imaging/avatarimage?direction=4&head_direction=4&action=sit&gesture=sml&size=m&user=<?php echo $username; ?>" alt="Avatar" class="perfil-avatar">
            <p><strong>Usuario:</strong> <?php echo $username; ?></p>

            <?php if (!empty($ua)): ?>
                <p><strong>Último Ascenso:</strong> <?php echo calcularTiempoTranscurrido($ua); ?></p>
            <?php endif; ?>

            <p><strong>Misión:</strong> <?php echo $motto; ?></p>

            <?php if ($estado === 'activo' && !empty($ini_time)): ?>
                <p><strong>Tiempo Actual:</strong> <span id="tiempo-actual"></span></p>

                <script>
                    let segundos = <?php echo $segundosTranscurridos; ?>;

                    function actualizarTiempo() {
                        const horas = String(Math.floor(segundos / 3600)).padStart(2, '0');
                        const minutos = String(Math.floor((segundos % 3600) / 60)).padStart(2, '0');
                        const segs = String(segundos % 60).padStart(2, '0');

                        document.getElementById('tiempo-actual').textContent = `${horas}:${minutos}:${segs}`;
                        segundos++;
                    }

                    actualizarTiempo();
                    setInterval(actualizarTiempo, 1000);
                </script>

            <?php elseif ($estado === 'inactivo' && !empty($tiempo_total)): ?>
                <p><strong>Tiempo Total:</strong> <?php echo segundosAHorasMinutosSegundos($tiempo_total); ?></p>
            <?php endif; ?>
        </div>
    </div>
</div>
