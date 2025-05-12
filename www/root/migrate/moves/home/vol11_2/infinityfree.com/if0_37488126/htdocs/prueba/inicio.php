<?php
// Conexión a la base de datos
$servername = "localhost";
$username = "forocsihabbo_wua";
$password = "makeciagreat";
$database = "forocsihabbo_wua";

$conn = new mysqli($servername, $username, $password, $database);
$conn->set_charset("utf8");

// Verificar conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Consulta para obtener el trabajador de la semana
$sql_trabajador = "SELECT username, avatar, motto FROM usuarios WHERE week_worker = 1 LIMIT 1";
$result_trabajador = $conn->query($sql_trabajador);

$trabajador = $result_trabajador->num_rows > 0 ? $result_trabajador->fetch_assoc() : [
    "username" => "Sin trabajador",
    "avatar" => "ruta/default-avatar.png",
    "motto" => "Sin misión"
];

// Consulta para el Top 10 de ascensos semanales
$sql_top = "
    SELECT l.usuario, COUNT(*) AS total_ascensos
    FROM logs_ascensos AS l
    JOIN usuarios AS u 
        ON CONVERT(l.usuario USING utf8mb3) COLLATE utf8mb3_unicode_ci = CONVERT(u.username USING utf8mb3) COLLATE utf8mb3_unicode_ci
    WHERE STR_TO_DATE(l.fecha, '%Y-%m-%d %H:%i:%s') >= '2025-01-22 22:00:00' 
    AND l.accion LIKE 'Ha ascendido%'
    AND u.rank < 9
    GROUP BY l.usuario
    ORDER BY total_ascensos DESC
    LIMIT 10;
";

$result_top = $conn->query($sql_top);
?>

<div class="section" id="inicio">
    <div class="inicio-container">
        <div class="grid-item">
            <div class="radio-container">
                <h5 class="radio-title">CSI Radio</h5>
                <div class="radio-content">
                    <div class="cover-album" id="coverAlbum">
                        <img id="coverImage" src="https://i.imgur.com/B1ZEG0e.jpeg" alt="Portada del Álbum">
                    </div>
                    <div class="radio-controls">
                        <button onclick="togglePlayPause()" id="playPauseBtn" class="radio-btn">
                            <i class="fas fa-pause"></i>
                        </button>
                        <input type="range" id="volumeControl" min="0" max="1" step="0.01" onchange="setVolume(this.value)">
                    </div>
                    <div class="radio-info">
                        <p id="currentSong">🎵 Canción: Desconocida</p>
                        <p id="currentArtist">🎤 Artista: Desconocido</p>
                    </div>
                    <audio id="audioPlayer" autoplay>
                        <source src="https://stream.zeno.fm/kgtunl22w1ouv" type="audio/mpeg">
                        Tu navegador no soporta el elemento de audio.
                    </audio>
                </div>
            </div>
            <div class="trabajador-semanal">
                <h5 class="trabajador-semanal-titulo">Trabajador Semanal</h5>
                <div class="trabajador-info">
                    <img src="<?php echo $trabajador['avatar']; ?>" alt="Trabajador de la Semana">
                    <p class="trabajador-semanal-user"><?php echo $trabajador['username']; ?></p>
                    <p class="trabajador-semanal-motto"><?php echo $trabajador['motto']; ?></p>
                </div>
            </div>
        </div>
        <div class="top-ascensos">
            <h5>Top 10 Ascensos Semanales</h5>
            <table>
                <thead>
                    <tr>
                        <th>Posición</th>
                        <th>Usuario</th>
                        <th>Ascensos</th>
                        <th>Lupas</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result_top->num_rows > 0) {
                        $posicion = 1;
                        while ($row = $result_top->fetch_assoc()) {
                            // Definir cantidad de lupas según la posición
                            $lupas = ($posicion == 1) ? 9 : (($posicion == 2) ? 7 : (($posicion == 3) ? 5 : 1));
                            echo "<tr>
                                    <td style='text-align: center; font-weight: bold;'>{$posicion}</td>
                                    <td style='text-align: center;'>{$row['usuario']}</td>
                                    <td style='text-align: center;'>{$row['total_ascensos']}</td>
                                    <td style='text-align: center;'>
                                        <span style='font-weight: bold;'>{$lupas}</span>
                                        <img src='https://images.habbo.com/c_images/album1584/DE149.png' alt='Lupa' style='width: 20px; vertical-align: middle;'>
                                    </td>
                                </tr>";
                            $posicion++;
                        }
                    } else {
                        echo "<tr><td colspan='4' style='text-align: center;'>No hay datos disponibles</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
        <div class="scroll-arrow" onclick="scrollToSection(1)">
            <img src="https://cdn-icons-png.flaticon.com/512/271/271210.png" alt="Flecha abajo">
        </div>
</div>

<?php $conn->close(); ?>