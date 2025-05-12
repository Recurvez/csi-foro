<?php
require('global.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $mensaje = isset($_POST['letterText']) ? $_POST['letterText'] : '';
    $username = $_SESSION['username'];

    if (!empty($mensaje)) {
        $stmt = $link->prepare("INSERT INTO san_valentin (username, mensaje) VALUES (?, ?)");
        if ($stmt) {
            $stmt->bind_param("ss", $username, $mensaje);
            if ($stmt->execute()) {
                echo "<script>
                    document.addEventListener('DOMContentLoaded', function() {
                        Swal.fire({
                            icon: 'success',
                            title: '¡Carta enviada!',
                            text: 'Tu carta ha sido enviada correctamente.',
                            confirmButtonText: '¡Genial!'
                        }).then(() => {
                            window.location.href = '#section2';
                        });
                    });
                </script>";
            } else {
                echo "<script>
                    document.addEventListener('DOMContentLoaded', function() {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Hubo un error al enviar la carta: " . addslashes($stmt->error) . "',
                        });
                    });
                </script>";
            }
            $stmt->close();
        } else {
            echo "<script>
                document.addEventListener('DOMContentLoaded', function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Error en la preparación de la consulta: " . addslashes($link->error) . "',
                    });
                });
            </script>";
        }
    } else {
        echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'warning',
                    title: '¡Ups!',
                    text: 'La carta no puede estar vacía.',
                });
            });
        </script>";
    }
}

$cartasPorPagina = 5; // Número de cartas por página
$paginaActual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
$offset = ($paginaActual - 1) * $cartasPorPagina;

// Obtener el total de cartas
$totalCartasQuery = $link->query("SELECT COUNT(*) as total FROM san_valentin");
$totalCartas = $totalCartasQuery->fetch_assoc()['total'];
$totalPaginas = ceil($totalCartas / $cartasPorPagina);

// Obtener cartas con límite y paginación
$result = $link->query("SELECT mensaje FROM san_valentin ORDER BY id DESC LIMIT $cartasPorPagina OFFSET $offset");
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Foro CSI - San Valentin</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        /* Scroll desactivado en el cuerpo para evitar conflictos */
        html,
        body {
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
            overflow: hidden;
        }

        /* Barra de navegación */
        nav {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            background: rgba(0, 0, 0, 0.7);
            padding: 10px 0;
            text-align: center;
            z-index: 1000;
            display: flex;
            align-items: center;
            /* Centra verticalmente el contenido */
            justify-content: center;
            /* Centra horizontalmente */
            height: 7%;
        }

        nav ul {
            list-style: none;
            padding: 0;
            margin: 0;
            display: flex;
            align-items: center;
            /* Centra verticalmente los elementos dentro de la lista */
        }

        nav ul li {
            margin: 0 15px;
        }

        nav ul li a {
            color: white;
            text-decoration: none;
            font-size: 18px;
            transition: color 0.3s ease-in-out;
            display: flex;
            align-items: center;
            /* Asegura que el texto de los enlaces esté centrado */
            height: 100%;
            /* Asegura que ocupe todo el alto del navbar */
        }

        /* Resaltar enlace activo */
        nav ul li a.active {
            font-weight: bold;
            text-decoration: underline;
        }

        /* Secciones */
        .section {
            width: 100vw;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            transition: background 0.3s ease-in-out;
            flex-shrink: 0;
            color: white;
            /* Texto blanco por defecto */
        }

        .event-info {
            background: rgba(0, 0, 0, 0.6);
            /* Fondo semitransparente */
            padding: 20px;
            border-radius: 15px;
            text-align: center;
            max-width: 600px;
            color: white;
            font-size: 20px;
            line-height: 1.5;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.3);
            animation: fadeIn 1.5s ease-in-out;
        }

        /* Animación de entrada */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .scroll-arrow {
            position: absolute;
            bottom: 30px;
            right: 90px;
            width: 50px;
            height: 50px;
            background: rgba(255, 255, 255, 0.8);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.3);
            animation: bounce 1.5s infinite ease-in-out;
        }

        .scroll-arrow img {
            width: 30px;
            height: 30px;
        }

        /* Animación de flotación */
        @keyframes bounce {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-10px);
            }
        }

        .warning-button {
            position: absolute;
            bottom: 30px;
            right: 30px;
            width: 50px;
            height: 50px;
            background: rgba(255, 255, 255, 0.8);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.3);
        }

        .warning-button span {
            font-size: 30px;
            color: black;
            font-weight: bold;
        }

        .warning-message {
            position: absolute;
            top: 10%;
            left: 80%;
            transform: translateX(-50%);
            background: rgba(28, 28, 28, 0.8);
            color: white;
            padding: 20px;
            border-radius: 10px;
            max-width: 500px;
            display: none;
            z-index: 1001;
        }

        .letter-container {
            background: url('https://www.transparenttextures.com/patterns/aged-paper.png');
            /* Textura de papel antiguo */
            background-color: #f5deb3;
            /* Color marrón-amarillo */
            padding: 20px;
            border-radius: 15px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.3);
            text-align: center;
            max-width: 600px;
            width: 80%;
            font-family: 'Courier New', cursive;
            color: #5a3e1b;
            border: 3px solid #8b5a2b;
        }

        .letter-container h2 {
            font-size: 24px;
            margin-bottom: 10px;
        }

        textarea {
            width: 90%;
            height: 200px;
            border: 2px solid #8b5a2b;
            border-radius: 10px;
            padding: 10px;
            font-family: 'Courier New', cursive;
            font-size: 18px;
            background: rgba(255, 248, 220, 0.9);
            /* Fondo tipo pergamino */
            resize: none;
            outline: none;
            color: #5a3e1b;
        }

        button {
            background: #8b5a2b;
            color: white;
            border: none;
            padding: 10px 20px;
            font-size: 18px;
            border-radius: 10px;
            cursor: pointer;
            transition: 0.3s;
        }

        button:hover {
            background: #5a3e1b;
        }

        .messages-container {
            background: rgba(0, 0, 0, 0.6);
            padding: 20px;
            border-radius: 15px;
            text-align: center;
            max-width: 700px;
            color: white;
            font-size: 18px;
            line-height: 1.5;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.3);
            animation: fadeIn 1.5s ease-in-out;
            width: 80%;
        }

        .message-box {
            background: rgba(255, 248, 220, 0.9);
            padding: 15px;
            border-radius: 10px;
            margin: 10px 0;
            color: #5a3e1b;
            font-family: 'Courier New', cursive;
            border: 2px solid #8b5a2b;
            text-align: left;
        }

    .pagination {
        margin-top: 20px;
        text-align: center;
    }

    .page-button {
        background: #8b5a2b;
        color: white;
        padding: 8px 15px;
        border-radius: 5px;
        text-decoration: none;
        margin: 0 5px;
        font-size: 16px;
        transition: background 0.3s;
    }

    .page-button:hover {
        background: #5a3e1b;
    }        

        /* Fondos con imágenes */
        #section1 {
            background: url('https://i.imgur.com/foKlKFQ.jpeg') center / cover no-repeat;
        }

        #section2 {
            background: url('https://act-webstatic.hoyoverse.com/puzzle/hk4e/pz_mDZ7Xhhdj3/resource/hippo/2803/a6d67b3f7d32d847bf73a1dcc0a44496_2599.png') center / cover no-repeat;
        }

        #section3 {
            background: url('https://act-webstatic.hoyoverse.com/puzzle/hk4e/pz_mDZ7Xhhdj3/resource/hippo/2803/a6d67b3f7d32d847bf73a1dcc0a44496_2599.png') center / cover no-repeat;
        }

        /* Media queries para móviles */
        @media (max-width: 600px) {
            nav ul {
                flex-direction: column;
                padding: 10px;
            }

            nav ul li {
                margin: 5px 0;
            }

            .event-info,
            .letter-container {
                font-size: 16px;
                padding: 15px;
            }

            .letter-container textarea {
                height: 150px;
            }
        }
    </style>
</head>

<body>

    <!-- Navegación -->
    <nav id="navbar">
        <ul>
            <li><a href="#section1">Info Evento</a></li>
            <li><a href="#section2">Participa</a></li>
            <li><a href="#section3">Mensajes</a></li>
            <li><a href="index.php">Volver al Foro</a></li>
        </ul>
    </nav>

    <!-- Secciones -->
    <div class="section" id="section1">
        <div class="event-info">
            <h1>🌹 Evento de San Valentín 🌹</h1>
            <p>
                Este San Valentín, participa en nuestro evento especial dejando una
                <strong>carta anónima</strong> en el foro con mensajes bonitos para otras personas. 💌✨<br>
                ¡Comparte amor y haz el día de alguien más especial! ❤️
            </p>
        </div>
        <div class="scroll-arrow" onclick="scrollToSection(1)">
            <img src="https://cdn-icons-png.flaticon.com/512/271/271210.png" alt="Flecha abajo">
        </div>
        <div class="warning-button" onclick="showWarning()">
            <span>!</span>
        </div>
    </div>

    <div class="section" id="section2">
        <div class="letter-container">
            <h2> Escribe tu carta anónima </h2>
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <textarea id="letterText" name="letterText" placeholder="Querido/a..."></textarea>
                <button type="submit">Enviar Carta</button>
            </form>
        </div>
    </div>

    <div class="section" id="section3">
        <div class="messages-container">
            <h2>💌 Cartas Enviadas 💌</h2>
            <div id="messages-list"></div>
            <div id="pagination-controls" class="pagination"></div>
        </div>
    </div>

    <div class="warning-message" id="warningMessage">
        <h3 style="text-align: center; font-size: 24px; color: white;">🚨 <strong>¡Advertencia!</strong> 🚨</h3>
        <ul style="list-style-type: none; padding: 0; color: white; font-size: 18px; line-height: 1.6;">
            <li><span style="font-weight: bold;">❌ No se permitirán mensajes ofensivos, discriminatorios o
                    inapropiados.</span></li>
            <li><span style="font-weight: bold;">👀 Los administradores revisarán las cartas antes de
                    publicarlas.</span></li>
            <li><span style="font-weight: bold;">⚖️ El incumplimiento de las normas puede resultar en sanciones
                    administrativas.</span></li>
            <li><span style="font-weight: bold;">🙏🏼 Por favor, sé respetuoso/a con los demás usuarios.</span></li>
            <li><span style="font-weight: bold;">❤️ ¡Gracias por tu colaboración!</span></li>
        </ul>
    </div>

    <script>
        let sections = document.querySelectorAll(".section");
        let navLinks = document.querySelectorAll("nav ul li a");
        let navbar = document.getElementById("navbar");
        let currentIndex = 0;
        let isScrolling = false;

        // Función para mostrar el mensaje de advertencia
        function showWarning() {
            let warningMessage = document.getElementById("warningMessage");
            warningMessage.style.display = "block";
            setTimeout(() => {
                warningMessage.style.display = "none";
            }, 10000); // Ocultar el mensaje después de 5 segundos
        }

        // Definir colores personalizados para cada sección
        const sectionColors = [
            { bg: "rgba(255, 209, 238, 0.8)", text: "black" },  // Sección 1
            { bg: "rgba(255, 209, 238, 0.8)", text: "black" }, // Sección 2
            { bg: "rgba(255, 209, 238, 0.8)", text: "black" }, // Sección 3
        ];

        function updateNavbarStyles() {
            let { bg, text } = sectionColors[currentIndex];

            navbar.style.background = bg;
            navLinks.forEach(link => {
                link.style.color = text; // Cambiar color de enlaces
                link.style.textDecorationColor = text; // Cambiar color del subrayado
            });

            // Resaltar el enlace activo
            navLinks.forEach(link => link.classList.remove("active"));
            navLinks[currentIndex]?.classList.add("active");
        }

        function scrollToSection(index) {
            if (index >= 0 && index < sections.length) {
                isScrolling = true;
                sections[index].scrollIntoView({ behavior: "smooth" });
                currentIndex = index;

                // Cambiar estilos dinámicamente
                updateNavbarStyles();

                // Evitar scrolls seguidos
                setTimeout(() => isScrolling = false, 800);
            }
        }

        // Detectar scroll del mouse
        window.addEventListener("wheel", (event) => {
            if (isScrolling) return;
            if (event.deltaY > 0) {
                scrollToSection(currentIndex + 1);
            } else {
                scrollToSection(currentIndex - 1);
            }
        });

        // Detectar clic en la navegación
        navLinks.forEach((link, index) => {
            link.addEventListener("click", (e) => {
                // Si el enlace es "Volver", permitir la navegación
                if (link.getAttribute("href") === "index.php") return;

                e.preventDefault();
                scrollToSection(index);
            });
        });

        // Ajustar tamaño de las secciones cuando se redimensiona la ventana
        function adjustSectionsSize() {
            sections.forEach(section => {
                section.style.height = `${window.innerHeight}px`;
                section.style.width = `${window.innerWidth}px`;
            });
        }

        window.addEventListener("resize", adjustSectionsSize);
        adjustSectionsSize();

        // Aplicar los estilos iniciales
        updateNavbarStyles();

        // Forzar que la página comience en la sección 1 al recargar
        window.onload = function () {
            scrollToSection(0);
        };

        document.querySelector(".scroll-arrow").addEventListener("click", function () {
            scrollToSection(1);
        });      

        document.addEventListener("DOMContentLoaded", function () {
            let paginaActual = 1;
            
            function cargarMensajes(pagina) {
                fetch(`fetch_messages.php?pagina=${pagina}`)
                    .then(response => response.json())
                    .then(data => {
                        let messagesList = document.getElementById("messages-list");
                        let paginationControls = document.getElementById("pagination-controls");

                        // Limpiar mensajes anteriores
                        messagesList.innerHTML = "";
                        data.mensajes.forEach(msg => {
                            let messageBox = document.createElement("div");
                            messageBox.className = "message-box";
                            messageBox.textContent = msg;
                            messagesList.appendChild(messageBox);
                        });

                        // Actualizar botones de paginación
                        paginationControls.innerHTML = "";

                        if (data.paginaActual > 1) {
                            let prevButton = document.createElement("a");
                            prevButton.href = "#";
                            prevButton.className = "page-button";
                            prevButton.textContent = "◀ Anterior";
                            prevButton.addEventListener("click", function (e) {
                                e.preventDefault();
                                cargarMensajes(data.paginaActual - 1);
                            });
                            paginationControls.appendChild(prevButton);
                        }

                        let pageInfo = document.createElement("span");
                        pageInfo.textContent = ` Página ${data.paginaActual} de ${data.totalPaginas} `;
                        paginationControls.appendChild(pageInfo);

                        if (data.paginaActual < data.totalPaginas) {
                            let nextButton = document.createElement("a");
                            nextButton.href = "#";
                            nextButton.className = "page-button";
                            nextButton.textContent = "Siguiente ▶";
                            nextButton.addEventListener("click", function (e) {
                                e.preventDefault();
                                cargarMensajes(data.paginaActual + 1);
                            });
                            paginationControls.appendChild(nextButton);
                        }
                    });
            }

            // Cargar la primera página
            cargarMensajes(paginaActual);
        });
    </script>


</body>

</html>