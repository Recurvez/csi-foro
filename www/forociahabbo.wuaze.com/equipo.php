<?php

// Consulta para obtener los usuarios y sus placas
$sql = "SELECT u.username, u.avatar, u.rank, u.motto, u.num_mision, u.TAG, p.imagen AS placa
        FROM usuarios u
        JOIN placas p ON u.rank = p.id
        WHERE u.rank IN (9, 10, 11, 12)
        ORDER BY u.num_mision DESC";

$result = $link->query($sql);

$rangos = [
    9 => "junta-directiva",
    10 => "admin",
    11 => "manager",
    12 => "founder"
];

$miembros = array_fill_keys(array_values($rangos), ["placa" => "", "usuarios" => [], "motto" => "", "num_mision" => "", "TAG" => ""]);

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $rol = $rangos[$row["rank"]];
        
        $usuario = [
            "nombre" => $row["username"],
            "img" => $row["avatar"],
            "motto" => $row["motto"],
            "TAG" => $row["TAG"],
            "num_mision" => $row["num_mision"]
        ];

        $miembros[$rol]["usuarios"][] = $usuario;
        $miembros[$rol]["placa"] = $row["placa"];
    }
}

$link->close();

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
                    <div class="mottouserperfil">' . htmlspecialchars($usuario["motto"]) . '</div>
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