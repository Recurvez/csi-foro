<?php
include "../Templates/Hk_Head.php";

// Obtener el rango y el TAG del usuario actual
$query = $link->query('SELECT username,rank, dev, TAG FROM usuarios WHERE username = "' . $username . '"');
while ($row = mysqli_fetch_array($query)) {
    $usernamee = $row['username'];
    $rangouser = $row['rank'];
    $dev = $row['dev'];
    $tag = $row['TAG'];

    // Permitir acceso si el usuario tiene 'dev == 1'
    if ($usernamee=='TheDantelp' || $usernamee=='novalboschu:' || $usernamee=='CARDARK50' || $dev == 1) {
        break;
    }

    // Limitar el acceso para ciertos rangos de usuarios
    if ($rangouser >= 1 && $rangouser <= 12) {
        echo '<script>window.location.href="index.php";</script>';
        exit;
    }
}

include "../Templates/Hk_Nav.php";
?>

<!-- Enlaces a CSS de DataTables -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap4.min.css">

<div class="container">
    <div class="row">
        <!-- Tercera sección: Usuarios activos -->
        <div class="panel panel-default">
            <div class="panel-heading green"
                style="display: grid; grid-template-columns: 1fr auto; align-items: center; position: relative;">
                <h3 class="panel-title"><?php echo 'Usuarios Activos'; ?></h3>
            </div>
            <div class="panel-body">
                <?php
                $resultado = $link->query("SELECT username FROM usuarios_activos");

                if ($resultado->num_rows > 0) {
                    echo "<ul class='list-group'>";
                    while ($row = $resultado->fetch_assoc()) {
                        echo "<li class='list-group-item'>" . htmlspecialchars($row['username']) . "</li>";
                    }
                    echo "</ul>";
                } else {
                    echo "<p>No hay usuarios activos en este momento.</p>";
                }
                ?>
            </div>
        </div>
    </div>
</div>


<!-- Scripts de DataTables -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap4.min.js"></script>

<script>
    $(document).ready(function () {
        // Inicializar DataTables
        $('#userTable').DataTable({
            "paging": true,
            "searching": true,
            "ordering": true,
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.11.5/i18n/Spanish.json" // Traducción al español
            }
        });

        $('#duplicateIpsTable').DataTable({
            "paging": true,
            "searching": true,
            "ordering": true,
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.11.5/i18n/Spanish.json"
            }
        });
    });
</script>

<?php include "../Templates/Footer.php"; ?>