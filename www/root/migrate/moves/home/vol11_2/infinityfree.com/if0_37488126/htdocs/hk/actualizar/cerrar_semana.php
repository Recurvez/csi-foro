<?php
include "../Templates/Hk_Head.php";

if ($rangouser > 10 || $dev == 1) {
    // Obtener datos actuales de la tabla `pagas`
    $resultado = $link->query("SELECT * FROM pagas");
    $datos_semana = [];
    while ($row = mysqli_fetch_assoc($resultado)) {
        $datos_semana[] = $row;
    }

    // Convertir datos a formato JSON
    $datos_json = json_encode($datos_semana);

    // Insertar en la tabla `semanas_cerradas`
    $fecha_cierre = date("Y-m-d H:i:s");
    $query = "INSERT INTO semanas_cerradas (fecha_cierre, datos) VALUES ('$fecha_cierre', '$datos_json')";
    if ($link->query($query)) {
        // Vaciar la tabla `pagas` después de cerrar la semana
        $link->query("TRUNCATE TABLE pagas");

        // Redirigir con un mensaje de éxito
        echo "<script>
            Swal.fire({
                icon: 'success',
                title: 'Semana Cerrada',
                text: 'Los datos han sido guardados correctamente.',
                confirmButtonText: 'OK'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = 'pagas2.php';
                }
            });
        </script>";
    } else {
        echo "Error al cerrar la semana: " . $link->error;
    }
} else {
    echo "Acceso denegado.";
}
?>
