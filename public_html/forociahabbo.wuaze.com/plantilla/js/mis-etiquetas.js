class Cabecera extends HTMLElement {
    constructor() {
        super();
        this.innerHTML = `
            <header>
                <img class="logo" src="img/logo.png" alt="Logo">
                <h1>SubUrban</h1>
            </header>
        `;
    }
}
window.customElements.define('mi-cabecera', Cabecera);

class Pie extends HTMLElement {
    constructor() {
        super();
        this.innerHTML = `
            <footer>
                &copy; 2025 - Jesús Rivera - 
                <a target="_blank" href="https://www.instagram.com/jesus10rm">
                    <img class="ig-icon" src="img/instagram_icon.png" alt="Instagram">
                </a>
            </footer>
        `;
    }
}
window.customElements.define('mi-pie', Pie);

class Menu extends HTMLElement {
    constructor() {
        super();
        this.innerHTML = `
            <nav class="menu">
                <ul>
                    <li><a href="index.html">Inicio</a></li>
                    <li><a href="#">Empresa</a></li>
                    <li><a href="#">Contacto</a></li>
                    <li><a href="#">Productos</a></li>
                    <li><a href="#">Carrito</a></li>
                    <li><a href="#">Login</a></li>
                </ul>
            </nav>
        `;
    }
}
window.customElements.define('mi-menu', Menu);
