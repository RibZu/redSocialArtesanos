const menu = document.getElementById('menu');       // contenedor que se expande
const sidebar = document.getElementById('sidebar'); // sidebar a mostrar
const icon = document.querySelector('.menu');       // icono hamburguesa

menu.addEventListener('click', () => {
    sidebar.classList.toggle('menu-toggle');  // expandir/cerrar sidebar
    icon.classList.toggle('menu-toggle');     // animar icono a X
});