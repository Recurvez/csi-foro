<?php
// Conexión a la base de datos
$servername = "localhost";
$username = "forocsihabbo_for";
$password = "makeciagreat";
$database = "forocsihabbo_for";

$conn = new mysqli($servername, $username, $password, $database);
$conn->set_charset("utf8");

// Verificar conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Definición de rangos
$rangos = [
    "SEG" => "Seguridad",
    "ENT" => "Entrenador",
    "LOG" => "Logística",
    "SUP" => "Supervisor",
    "DIR" => "Director",
    "PRE" => "Presidente",
    "OP" => "Operaciones",
    "JD" => "Junta Directiva",
    "ADM" => "Administrador",    
    "MNG" => "Manager",
    "F" => "Founder"
];

$misionesPorRango = [];
$imagenesRangos = [];

foreach ($rangos as $id => $nombre) {
    $sqlMisiones = "SELECT id, nombre, precio FROM misiones WHERE id = '$id' ORDER BY num DESC";
    $resultMisiones = $conn->query($sqlMisiones);

    $misiones = [];
    if ($resultMisiones->num_rows > 0) {
        while ($row = $resultMisiones->fetch_assoc()) {
            $row['precio'] = ($row['precio'] == 0) ? "No está en venta" : "$" . $row['precio'];
            $misiones[] = $row;
        }
    }
    $misionesPorRango[$id] = $misiones;

    $sqlImagen = "SELECT imagen FROM placas WHERE code = '$id' LIMIT 1";
    $resultImagen = $conn->query($sqlImagen);
    $imagenesRangos[$id] = ($resultImagen->num_rows > 0) ? $resultImagen->fetch_assoc()['imagen'] : "default.png";
}
$conn->close();
?>
<div class="section" id="rangos">
    <div id="rangos2">
    <!-- Contenedor de botones de rangos -->
    <div class="misiones-botones">
        <?php foreach ($rangos as $id => $nombre): ?>
            <button class="ranks-btn" onclick="mostrarMisiones('<?php echo $id; ?>')">
                <img src="<?php echo $imagenesRangos[$id]; ?>" alt="<?php echo $nombre; ?>" width="80">
            </button>
        <?php endforeach; ?>
    </div>

    <!-- Contenedor de misiones con altura fija -->
    <div class="misiones-contenedor">
        <div class="misiones-wrapper">
            <?php foreach ($misionesPorRango as $id => $misiones): ?>
                <table class="tabla-misiones" id="tabla-<?php echo $id; ?>"
                    style="display: <?php echo ($id === 'SEG') ? 'table' : 'none'; ?>;">
                    <?php foreach ($misiones as $mision): ?>
                        <tr>
                            <td><?php echo $mision["nombre"]; ?></td>
                            <td><?php echo $mision["precio"]; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            <?php endforeach; ?>
        </div>
    </div>
    </div>
</div>


<script>


</script>