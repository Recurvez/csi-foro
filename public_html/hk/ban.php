<?php
include "../Templates/Hk_Head.php";

// Obtener el rango del usuario logueado para verificar permisos
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
    if ($rangouser >= 1 && $rangouser <= 9) {
        echo '<script>window.location.href="index.php";</script>';
        exit;
    }
}

include "../Templates/Hk_Nav.php";
?>

<div class="container">
    <div class="row">
        <div class="panel panel-default">
            <div class="panel-heading blue d-flex justify-content-between align-items-center"
                style="display: flex; justify-content: space-between; align-items: center;">
                <h3 class="panel-title" style="margin: 0;"><?php echo $lang[282]; ?></h3>
                <div class="input-group" style="width: 250px;">
                    <input type="text" id="search" placeholder="Buscar usuario..." class="form-control"
                        style="z-index: 1;">
                </div>
            </div>
            <div class="panel-body">
                <div id="loader" style="text-align:center; margin-left:50%;">
                    <img src="loader.gif">
                </div>
                <div class="outer_div"></div><!-- Datos ajax Final -->
            </div>
        </div>

        <div style="width: 70%" class="panel panel-default">
            <div class="panel-heading green">
                <h3 class="panel-title"><?php echo $lang[405]; ?></h3>
            </div>
            <div class="panel-body">
                <form action="" method="post" enctype="multipart/form-data">
                    <div style="float:left;margin-left:10px;">
                        <label><?php echo $lang[175]; ?></label>
                        <input style="margin-bottom: 10px;width:200px;" type="text" required class="form-control"
                            name="user" id="userInput" placeholder="<?php echo $lang[175]; ?>" />

                        <ul id="suggestions"
                            style="list-style-type: none; margin: 0; padding: 5px; background-color: #f8f9fa; border: 1px solid #ddd; max-height: 150px; overflow-y: auto; width: 200px; position: absolute; z-index: 1000; display: none; border-radius: 4px; box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);">
                            <!-- Las sugerencias aparecerán aquí -->
                        </ul>


                    </div>

                    <div style="float:left;margin-left:10px;">
                        <label><?php echo $lang[307]; ?></label>
                        <input style="margin-bottom: 10px;width:300px;" type="text" required class="form-control"
                            name="razon" placeholder="<?php echo $lang[406]; ?>" />
                    </div>

                    <div style="float:left;margin-left:10px;">
                        <label>
                            <input type="checkbox" id="permanentBan" name="permanentBan" style="margin-right: 5px;">
                            <?php echo 'Baneo permanente'; ?>
                        </label>
                    </div>

                    <div style="float:left;margin-left:10px;" id="banDateContainer">
                        <label><?php echo $lang[308]; ?></label>
                        <input style="margin-bottom: 10px;width:auto;" type="date" class="form-control" name="ban_f"
                            id="ban_f" required />
                    </div>

                    <div style="margin-right: 10%;margin-left: 10px;">
                        <input class="btn btn-primary" name="guardar" type="submit" value="<?php echo $lang[325]; ?>"
                            style="width: 120px;margin-top: 10px;" />
                    </div>
                </form>

                <?php
                if (isset($_POST['guardar']) && !empty($_POST['user'])) {
                    $user = $_POST['user'];
                    $razon = $_POST['razon'];
                    $ban_i = date("d-m-Y");

                    // Verifica si el checkbox de baneo permanente está marcado
                    if (isset($_POST['permanentBan'])) {
                        $ban_f = '01-01-9999'; // Fecha para baneo permanente
                    } else {
                        $ban_f = DateTime::createFromFormat('Y-m-d', $_POST['ban_f'])->format('d-m-Y');
                    }

                    // Verifica si el usuario existe en la base de datos
                    $resultado = $link->query("SELECT username FROM usuarios WHERE username = '$user'");
                    if ($resultado->num_rows > 0) {
                        // El usuario existe
                        $user_correcto = $resultado->fetch_assoc()['username'];

                        // Verifica si ya está baneado
                        $resultado = $link->query("SELECT usuario FROM baneo WHERE usuario = '$user_correcto'");
                        if ($resultado->num_rows > 0) {
                            header("Location: ban.php?usuario_existente");
                        } else {
                            // Inserta el baneo
                            $consulta = "UPDATE usuarios SET validacion = '0' ,ban='1', ban_i='$ban_i', ban_f='$ban_f' WHERE username='$user_correcto'";
                            $link->query($consulta);

                            $enviar = "INSERT INTO baneo (usuario, razon, ban_i, ban_f, autor) VALUES ('$user_correcto', '$razon', '$ban_i', '$ban_f', '$username')";
                            if ($link->query($enviar)) {
                                header("Location: ban.php?guardado");
                            }

                            // Guardar acción en Logs
                            $fecha_log = date('Y-m-d H:i:s');
                            $accion = "Ha despedido a $user_correcto por el motivo de: $razon";
                            $enviar_log = "INSERT INTO logs (usuario, accion, fecha) VALUES ('" . $username . "', '" . $accion . "', '" . $fecha_log . "')";
                            $link->query($enviar_log); // Log guardado en base de datos
                        }
                    } else {
                        // Usuario no encontrado
                        echo '<div class="alert alert-danger">Usuario no encontrado.</div>';
                    }
                }
                ?>
            </div>
        </div>
    </div>
</div>

<script>
    // Captura el evento de tecleo para realizar la búsqueda en tiempo real
    document.getElementById("search").addEventListener("keyup", function () {
        var query = this.value;
        load(1, query);  // Pasar el valor del campo de búsqueda
    });

    // Función para cargar los datos con AJAX
    function load(page, search = '') {
        var parametros = { "action": "ajax", "page": page, "search": search };
        $("#loader").fadeIn('slow');
        $.ajax({
            url: '../kernel/ajax/Hk_ban_ajax.php',
            data: parametros,
            beforeSend: function (objeto) {
                $("#loader").html("<img src='loader.gif'>");
            },
            success: function (data) {
                $(".outer_div").html(data).fadeIn('slow');
                $("#loader").html("");
            }
        });
    }

    $(document).ready(function () {
        load(1);  // Cargar los datos cuando la página se carga
    });
</script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        $('#userInput').on('keyup', function () {
            let search = $(this).val(); // Obtener el valor del campo de búsqueda

            if (search.length > 2) { // Solo busca si el usuario ha ingresado más de 2 caracteres
                $.ajax({
                    url: '../kernel/ajax/buscar_usuarios.php',
                    method: 'GET',
                    data: { search: search },
                    success: function (data) {
                        let suggestions = JSON.parse(data); // Parsear la respuesta JSON
                        let suggestionList = $('#suggestions');

                        suggestionList.empty(); // Limpiar las sugerencias anteriores

                        if (suggestions.length > 0) {
                            suggestions.forEach(function (user) {
                                suggestionList.append('<li class="suggestion-item" style="padding: 8px; cursor: pointer; border-bottom: 1px solid #ddd; background-color: #f8f9fa;" onmouseover="this.style.backgroundColor=\'#e0e0e0\'" onmouseout="this.style.backgroundColor=\'#f8f9fa\'">' + user + '</li>');
                            });
                            suggestionList.show(); // Mostrar las sugerencias
                        } else {
                            suggestionList.hide(); // Ocultar si no hay resultados
                        }
                    }
                });
            } else {
                $('#suggestions').hide(); // Ocultar si el campo está vacío o tiene pocos caracteres
            }
        });

        // Al hacer clic en una sugerencia, rellenar el campo con el nombre seleccionado
        $(document).on('click', '.suggestion-item', function () {
            $('#userInput').val($(this).text());
            $('#suggestions').hide(); // Ocultar las sugerencias
        });
    });
</script>
<script>
    document.getElementById('permanentBan').addEventListener('change', function () {
        const banDateContainer = document.getElementById('banDateContainer');
        const banDateInput = document.getElementById('ban_f');

        if (this.checked) {
            banDateInput.value = ''; // Limpia el valor del campo de fecha
            banDateInput.disabled = true; // Deshabilita el campo de fecha
        } else {
            banDateInput.disabled = false; // Habilita el campo de fecha
        }
    });
</script>

<?php include "../Templates/Footer.php"; ?>