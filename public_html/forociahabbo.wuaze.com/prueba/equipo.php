<?php
// Conexión a la base de datos
$servername = "localhost";
$username = "forocsihabbo_wua";
$password = "makeciagreat";
$database = "forocsihabbo_wua";

$conn = new mysqli($servername, $username, $password, $database);
$conn->set_charset("utf8"); // <- Añade esta línea después de la conexión


if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Consulta para obtener los usuarios y sus placas
$sql = "SELECT u.username, u.avatar, u.rank, p.imagen AS placa
        FROM usuarios u
        JOIN placas p ON u.rank = p.id
        WHERE u.rank IN (9,10,11,12)";

$result = $conn->query($sql);

$miembros = [
    "junta-directiva" => ["placa" => "", "usuarios" => []],
    "admin" => ["placa" => "", "usuarios" => []],
    "manager" => ["placa" => "", "usuarios" => []],
    "founder" => ["placa" => "", "usuarios" => []]
];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $usuario = [
            "nombre" => $row["username"],
            "img" => $row["avatar"]
        ];

        switch ($row["rank"]) {
            case 9:
                $miembros["junta-directiva"]["usuarios"][] = $usuario;
                $miembros["junta-directiva"]["placa"] = $row["placa"];
                break;
            case 10:
                $miembros["admin"]["usuarios"][] = $usuario;
                $miembros["admin"]["placa"] = $row["placa"];
                break;
            case 11:
                $miembros["manager"]["usuarios"][] = $usuario;
                $miembros["manager"]["placa"] = $row["placa"];
                break;
            case 12:
                $miembros["founder"]["usuarios"][] = $usuario;
                $miembros["founder"]["placa"] = $row["placa"];
                break;
        }
    }
}

$conn->close();
?>

<div class="section" id="equipo">
<div id="equipo2">
    <div class="equipo-container">
        <!-- Botones de rangos -->
        <div class="rank-buttons">
            <button class="rank-btn founder active" onclick="mostrarMiembros('founder')" data-rango="founder">
                <img src="<?php echo $miembros['founder']['placa']; ?>" alt="Founder">
            </button>
            <button class="rank-btn manager" onclick="mostrarMiembros('manager')" data-rango="manager">
                <img src="<?php echo $miembros['manager']['placa']; ?>" alt="Manager">
            </button>
            <button class="rank-btn admin" onclick="mostrarMiembros('admin')" data-rango="admin">
                <img src="<?php echo $miembros['admin']['placa']; ?>" alt="Admin">
            </button>
            <button class="rank-btn junta-directiva" onclick="mostrarMiembros('junta-directiva')" data-rango="junta-directiva">
                <img src="<?php echo $miembros['junta-directiva']['placa']; ?>" alt="Junta Directiva">
            </button>
        </div>
        <!-- Contenedor de la tabla de miembros -->
        <div class="miembros-section">
    <div class="placa-titulo-container">
        <img id="placa-imagen" src="<?php echo $miembros['founder']['placa']; ?>" alt="Placa Founder">
        <h2 id="titulo-rango">FOUNDER</h2>
    </div>

    <div id="miembros-container">
        <?php
        foreach ($miembros["founder"]["usuarios"] as $usuario) {
            echo '<div class="miembro">
                    <div class="userperfileindex">
                        <img src="' . htmlspecialchars($usuario["img"]) . '" alt="' . htmlspecialchars($usuario["nombre"]) . '">
                    </div>
                    <div class="nameuserperfil">' . htmlspecialchars($usuario["nombre"]) . '</div>
                  </div>';
        }
        ?>
    </div>

    <!-- Botones de navegación -->
    <div class="carrusel-controles">
    <button id="prev-btn" onclick="prevSlide()">◀</button>
    <button id="next-btn" onclick="nextSlide()">▶</button>
    </div>
</div>
    </div>
    </div>
</div>

<script>
    const miembrosData = <?php echo json_encode($miembros); ?>;
</script>