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
    { bg: "rgba(255, 209, 238, 0.8)", text: "white" },  // Sección 1 (Navbar oculto)
    { bg: "rgba(255, 209, 238, 0.8)", text: "white" }, // Sección 2
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

        // Mostrar/ocultar navbar
        /*
        if (currentIndex === 0) {
            navbar.classList.add("hidden");
        } else {
            navbar.classList.remove("hidden");
        } 
        */

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

// Ocultar navbar al inicio
if (currentIndex === 0) {
    navbar.classList.add("hidden");
}

// Aplicar los estilos iniciales
updateNavbarStyles();

document.querySelector(".scroll-arrow").addEventListener("click", function() {
    scrollToSection(1);
});