//NAVBAR
document.addEventListener('DOMContentLoaded', function() {
    const menuToggle = document.querySelector('.menu-toggle');
    const navLinks = document.querySelector('.nav-links');

    menuToggle.addEventListener('click', function() {
        navLinks.classList.toggle('active');
    });
});

//EVENTO PARA EVITAR EL ZOOM EN DISPOSITIVOS TÁCTILES

document.addEventListener('gesturestart', function (e) {
    e.preventDefault();
    document.body.style.zoom = 1; // Restablece el zoom al tamaño original
});

document.addEventListener('gesturechange', function (e) {
    e.preventDefault();
    document.body.style.zoom = 1; // Restablece el zoom al tamaño original
});

document.addEventListener('gestureend', function (e) {
    e.preventDefault();
    document.body.style.zoom = 1; // Restablece el zoom al tamaño original
});

//EVENTO PARA EVITAR EL ZOOM EN NAVEGADORES DE ESCRITORIO
window.addEventListener('wheel', function(e) {
    if (e.ctrlKey) {
        e.preventDefault();
        document.body.style.zoom = 1; // Restablece el zoom al tamaño original
    }
}, { passive: false });

window.addEventListener('keydown', function(e) {
    if ((e.ctrlKey && (e.key === '+' || e.key === '-' || e.key === '0')) || (e.key === 'Meta' && (e.key === '+' || e.key === '-' || e.key === '0'))) {
        e.preventDefault();
        document.body.style.zoom = 1; // Restablece el zoom al tamaño original
    }
});

//EVENTO PARA MONITOREAR CAMBIOS DE TAMAÑO DE LA VENTANA Y RESTABLECER EL ZOOM
window.addEventListener('resize', function() {
    document.body.style.zoom = 1; // Restablece el zoom al tamaño original
});

//SCRIPTS GENERALES

// SCRIPTS PARA LA PÁGINA DE INICIO

let currentIndex = 0;
let isScrolling = false;
const sections = document.querySelectorAll(".section");
const navLinks = document.querySelectorAll("nav ul li a");

// Función para desplazarse a una sección específica
function scrollToSection(index) {
    if (index >= 0 && index < sections.length) {
        isScrolling = true;
        sections[index].scrollIntoView({ behavior: "smooth", block: "start" });
        updateActiveNav(index);
        currentIndex = index; // Actualiza el índice actual
        setTimeout(() => isScrolling = false, 500);
    }
}

// Detectar scroll con el mouse en escritorio
window.addEventListener("wheel", (event) => {
    if (isScrolling) return;

    const scrollThreshold = 5; // Ajusta este valor, mayor = menos sensible

    if (event.deltaY > scrollThreshold) {
        scrollToSection(currentIndex + 1);
    } else if (event.deltaY < -scrollThreshold) {
        scrollToSection(currentIndex - 1);
    }
});

// Función para actualizar la clase "active" en el navbar
function updateActiveNav(index) {
    navLinks.forEach(link => link.classList.remove("active"));
    navLinks[index].classList.add("active");
}

// Detectar clic en la navegación
navLinks.forEach((link, index) => {
    link.addEventListener("click", (e) => {
        // Verifica si el enlace es "login.php"
        if (link.getAttribute("href") === "login.php") {
            return; // Permite la navegación normal
        }
        
        e.preventDefault();
        scrollToSection(index);
    });
});

// FUNCIONALIDAD PARA MÓVILES - DETECTAR SWIPE (DESLIZAMIENTO)
let startY = 0;
let endY = 0;
let startTime = 0;
const touchThreshold = 50; // Sensibilidad del swipe
const maxSwipeDuration = 500; // Tiempo máximo en milisegundos para considerar swipe

window.addEventListener("touchstart", (e) => {
    startY = e.touches[0].clientY;
    startTime = new Date().getTime(); // Registrar el tiempo de inicio
});

window.addEventListener("touchend", (e) => {
    endY = e.changedTouches[0].clientY;
    let swipeDistance = startY - endY;
    let swipeTime = new Date().getTime() - startTime; // Calcular duración del swipe

    // Verificar que el swipe sea lo suficientemente largo y rápido
    if (Math.abs(swipeDistance) > touchThreshold && swipeTime < maxSwipeDuration) {
        if (swipeDistance > 0) {
            scrollToSection(currentIndex + 1); // Deslizar hacia arriba
        } else {
            scrollToSection(currentIndex - 1); // Deslizar hacia abajo
        }
    }
});

// Ajustar tamaño de las secciones cuando se redimensiona la ventana
function adjustSectionsSize() {
    sections.forEach(section => {
        section.style.height = `${document.documentElement.clientHeight}px`;
    });
}

window.addEventListener("resize", adjustSectionsSize);
adjustSectionsSize();

// Forzar que la página comience en la primera sección
window.onload = function() {
    scrollToSection(0); // Se inicia en la primera sección
};


// SCRIPTS EQUIPO - Carrusel de miembros

// Definimos variables globales
let currentSlide = 0;
const itemsPerPage = 4;

// Función para actualizar el carrusel
function actualizarCarrusel(rango) {
    const miembros = miembrosData[rango].usuarios;
    const contenedor = document.getElementById("miembros-container");
    
    contenedor.innerHTML = ""; // Limpiar el contenedor

    if (miembros.length === 0) {
        contenedor.innerHTML = "<p>No hay miembros en este rango.</p>";
        return;
    }

    // Calcular los miembros a mostrar
    const start = currentSlide * itemsPerPage;
    const end = Math.min(start + itemsPerPage, miembros.length); // Corrección: Evitar que end exceda el tamaño del array
    const miembrosVisibles = miembros.slice(start, end);

    // Agregar miembros al contenedor
    miembrosVisibles.forEach(miembro => {
        const miembroDiv = document.createElement("div");
        miembroDiv.classList.add("miembro");
        miembroDiv.innerHTML = `
            <div class="userperfileindex">
                <img src="${miembro.img}" alt="${miembro.nombre}">
            </div>
            <div class="nameuserperfil">${miembro.nombre}</div>
        `;
        contenedor.appendChild(miembroDiv);
    });

    // Habilitar o deshabilitar botones de navegación
    document.getElementById("prev-btn").disabled = currentSlide === 0;
    document.getElementById("next-btn").disabled = end >= miembros.length;
}

// Función para mostrar los miembros según el rango seleccionado
function mostrarMiembros(rango) {
    currentSlide = 0; // Reiniciar a la primera página al cambiar de rango
    const titulo = document.getElementById("titulo-rango");
    const placaImagen = document.getElementById("placa-imagen");

    const nombresRangos = {
        "founder": "FOUNDER",
        "manager": "MANAGER",
        "admin": "ADMIN",
        "junta-directiva": "JUNTA DIRECTIVA"
    };

    titulo.textContent = nombresRangos[rango];
    placaImagen.src = miembrosData[rango].placa;

    // Actualizar la lista de miembros (esta línea es la que faltaba)
    actualizarCarrusel(rango);

    // Quitar la clase 'active' de todos los botones y activarla en el seleccionado
    document.querySelectorAll(".rank-btn").forEach(btn => btn.classList.remove("active"));
    document.querySelector(`.rank-btn[data-rango="${rango}"]`).classList.add("active");
}

// Botones de navegación
function prevSlide() {
    if (currentSlide > 0) {
        currentSlide--;
        const rango = document.querySelector(".rank-btn.active").dataset.rango;
        actualizarCarrusel(rango);
    }
}

function nextSlide() {
    const rango = document.querySelector(".rank-btn.active").dataset.rango;
    if ((currentSlide + 1) * itemsPerPage < miembrosData[rango].usuarios.length) {
        currentSlide++;
        actualizarCarrusel(rango);
    }
}

// Mostrar los Founder por defecto al cargar la página
document.addEventListener("DOMContentLoaded", () => mostrarMiembros("founder"));


//SCRIPTS PARA LA PÁGINA DE MISIONES

function mostrarMisiones(id) {
    // Obtener la tabla activa
    const nuevaTabla = document.getElementById('tabla-' + id);

    // Evitar que la tabla activa se oculte
    document.querySelectorAll('.tabla-misiones').forEach(tabla => {
        if (tabla !== nuevaTabla) { // Solo ocultar si no es la nueva tabla
            tabla.style.opacity = "0";
            tabla.style.zIndex = "0"; // Enviar al fondo
            setTimeout(() => {
                tabla.style.display = "none";
            }, 500); // Ocultar después de la animación
        }
    });

    // Mostrar la nueva tabla con animación
    if (nuevaTabla) {
        nuevaTabla.style.display = "table";
        setTimeout(() => {
            nuevaTabla.style.opacity = "1";
            nuevaTabla.style.zIndex = "1"; // Traer al frente
        }, 50);

        // Ajustar altura del contenedor
        const contenedorMisiones = document.querySelector('.misiones-contenedor');
        contenedorMisiones.style.height = nuevaTabla.offsetHeight + 'px';
    }
}

// Mostrar por defecto el de SEG al cargar la página
document.addEventListener("DOMContentLoaded", function () {
    // Esperar a que las tablas se carguen completamente antes de mostrar la primera
    setTimeout(() => {
        mostrarMisiones('SEG');
    }, 0);
});

//SCRIPTS PARA LA PÁGINA DE NOTICIAS

let paginaActual = 1;
let totalPaginas = 1; // Se actualizará dinámicamente

document.addEventListener("DOMContentLoaded", function () {
    function cargarNoticias() {
        fetch("ajax/noticias_ajax.php", {
            method: "POST",
            headers: { "Content-Type": "application/x-www-form-urlencoded" },
            body: "pagina=" + paginaActual
        })
        .then(response => response.json())
        .then(data => {
            document.querySelector(".noticias-contenedor").innerHTML = data.noticias;
            totalPaginas = data.totalPaginas;
            actualizarPaginacion();
        });
    }

    function actualizarPaginacion() {
        document.getElementById("pageNumber").innerText = `Página ${paginaActual} de ${totalPaginas}`;

        // Deshabilitar botones si estamos en el límite
        document.getElementById("prevPage").disabled = paginaActual === 1;
        document.getElementById("nextPage").disabled = paginaActual === totalPaginas;
    }

    // Delegación de eventos para "Leer más"
    document.addEventListener("click", function (e) {
        if (e.target.classList.contains("noticia-link")) {
            e.preventDefault();
            let noticiaID = e.target.dataset.id;

            fetch("ajax/noticia_obtener.php", {
                method: "POST",
                headers: { "Content-Type": "application/x-www-form-urlencoded" },
                body: "id=" + noticiaID
            })
            .then(response => response.json())
            .then(data => {
                if (!data.error) {
                    document.getElementById("modalImagen").src = data.imagen;
                    document.getElementById("modalNoticia").innerHTML = data.noticia; // Usamos innerHTML para renderizar correctamente
                    document.getElementById("contMeGusta").innerText = data.megusta;
                    document.getElementById("contNoMeGusta").innerText = data.no_megusta;
                    
                    // Guardar el ID de la noticia en los botones para poder enviarlo después
                    document.getElementById("btnMeGusta").dataset.id = noticiaID;
                    document.getElementById("btnNoMeGusta").dataset.id = noticiaID;

                    document.getElementById("noticiaModal").style.display = "flex";
                }
            });
        }
    });

// Cerrar modal al hacer clic en la "X"
document.querySelector(".cerrar-modal").addEventListener("click", function () {
    document.getElementById("noticiaModal").style.display = "none";
    document.body.classList.remove("modal-abierto"); // Habilitar scroll de la página
});

    // Botones de paginación
    document.getElementById("prevPage").addEventListener("click", function () {
        if (paginaActual > 1) {
            paginaActual--;
            cargarNoticias();
        }
    });

    document.getElementById("nextPage").addEventListener("click", function () {
        if (paginaActual < totalPaginas) {
            paginaActual++;
            cargarNoticias();
        }
    });

    // Botones de "Me gusta" y "No me gusta"
    document.getElementById("btnMeGusta").addEventListener("click", function () {
        let noticiaID = this.dataset.id;
        actualizarReaccion(noticiaID, "megusta");
    });

    document.getElementById("btnNoMeGusta").addEventListener("click", function () {
        let noticiaID = this.dataset.id;
        actualizarReaccion(noticiaID, "nomegusta");
    });

    function actualizarReaccion(noticiaID, tipo) {
        fetch("ajax/noticia_megusta.php", {
            method: "POST",
            headers: { "Content-Type": "application/x-www-form-urlencoded" },
            body: `id=${noticiaID}&tipo=${tipo}`
        })
        .then(response => response.json())
        .then(data => {
            if (!data.error) {
                document.getElementById("contMeGusta").innerText = data.megusta;
                document.getElementById("contNoMeGusta").innerText = data.no_megusta;
            }
        });
    }

    // Cargar la primera página al inicio
    cargarNoticias();
});




//SCRIPTS PARA LA PÁGINA DE EVENTOS

let paginaEventos = 1;
let totalPaginasEventos = 1;

function cargarEventos() {
    fetch("ajax/eventos_ajax.php", {
        method: "POST",
        headers: { "Content-Type": "application/x-www-form-urlencoded" },
        body: "pagina=" + paginaEventos
    })
    .then(response => response.json())
    .then(data => {
        document.querySelector(".eventos-contenedor").innerHTML = data.eventos;
        totalPaginasEventos = data.totalPaginas;
        actualizarPaginacionEventos();
    });
}

function actualizarPaginacionEventos() {
    document.getElementById("pageNumberEventos").innerText = `Página ${paginaEventos} de ${totalPaginasEventos}`;

    document.getElementById("prevEvento").disabled = (paginaEventos === 1);
    document.getElementById("nextEvento").disabled = (paginaEventos === totalPaginasEventos);
}

document.getElementById("prevEvento").addEventListener("click", function () {
    if (paginaEventos > 1) {
        paginaEventos--;
        cargarEventos();
    }
});

document.getElementById("nextEvento").addEventListener("click", function () {
    if (paginaEventos < totalPaginasEventos) {
        paginaEventos++;
        cargarEventos();
    }
});

// Cargar eventos al inicio
cargarEventos();


//SCRIPTS PARA LA RADIO

const url = 'https://api.zeno.fm/mounts/metadata/subscribe/kgtunl22w1ouv';
const audio = document.getElementById('audioPlayer');
const playPauseBtn = document.getElementById('playPauseBtn');
const volumeControl = document.getElementById('volumeControl');

connectToEventSource(url);

function connectToEventSource(url) {
    const eventSource = new EventSource(url);
    eventSource.addEventListener('message', function(event) {
        processData(event.data);
    });
    eventSource.addEventListener('error', function(event) {
        console.error('Error en la conexión de eventos:', event);
    });
}

function processData(data) {
    const parsedData = JSON.parse(data);
    if (parsedData.streamTitle) {
        let artist, song;
        const streamTitle = parsedData.streamTitle;

        if (streamTitle.includes('-')) {
            [artist, song] = streamTitle.split(' - ');
        } else {
            artist = '';
            song = streamTitle;
        }

        document.getElementById('currentSong').innerText = 'Canción: ' + song.trim();
        document.getElementById('currentArtist').innerText = 'Artista: ' + artist.trim();
    }
}

function togglePlayPause(event) {
    if (event) event.preventDefault(); // Evita errores si event es undefined

    if (audio.paused) {
        audio.play();
        playPauseBtn.innerHTML = '<i class="fa fa-pause"></i>';
    } else {
        audio.pause();
        playPauseBtn.innerHTML = '<i class="fa fa-play"></i>';
    }
}

function setVolume(volume) {
    audio.volume = volume;
    localStorage.setItem('userVolume', volume);
}

window.addEventListener('load', () => {
    const savedVolume = localStorage.getItem('userVolume');
    if (savedVolume !== null) {
        volumeControl.value = savedVolume;
        audio.volume = savedVolume;
    } else {
        volumeControl.value = 0.2;
        audio.volume = 0.2;
    }
});


//SCRIPTS LOGIN

document.addEventListener("DOMContentLoaded", function () {
    const loginLink = document.querySelector('a[href="login.php"]');
    const popup = document.getElementById("loginPopup");
    const popupBody = document.getElementById("popup-body");
    const closePopup = document.querySelector(".popup-close");

    if (loginLink) {
        loginLink.addEventListener("click", function (e) {
            e.preventDefault(); // Evita la navegación
            popup.style.display = "flex"; // Muestra el popup

            // Carga login.php dentro del popup
            fetch("login.php")
                .then(response => response.text())
                .then(data => {
                    popupBody.innerHTML = data;
                    loadScripts(); // Carga los scripts necesarios
                })
                .catch(() => {
                    popupBody.innerHTML = "<p>Error al cargar el login</p>";
                });
        });
    }

    function loadScripts() {
        loadJQuery(() => {
            initLoginScripts();
            loadRecaptcha(); // Carga reCAPTCHA después de insertar el contenido
        });
    }

    function loadJQuery(callback) {
        if (typeof jQuery == "undefined") {
            const script = document.createElement("script");
            script.src = "https://code.jquery.com/jquery-3.6.0.min.js";
            script.onload = callback;
            document.body.appendChild(script);
        } else {
            callback();
        }
    }

    function loadRecaptcha() {
        const recaptchaScript = document.createElement("script");
        recaptchaScript.src = "https://www.google.com/recaptcha/api.js";
        recaptchaScript.async = true;
        recaptchaScript.defer = true;
        document.body.appendChild(recaptchaScript);
    }

    function initLoginScripts() {
        $(document).on("click", "#signup", function () {
            $(".message").css("transform", "translateX(100%)").removeClass("login").addClass("signup");
        });

        $(document).on("click", "#login", function () {
            $(".message").css("transform", "translateX(0)").removeClass("signup").addClass("login");
        });
    }

    // Cerrar el popup al hacer clic en la 'X' o fuera del popup
    closePopup.addEventListener("click", () => (popup.style.display = "none"));
    window.addEventListener("click", (e) => {
        if (e.target === popup) popup.style.display = "none";
    });
});