document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('modoOscuroToggle').addEventListener('click', function() {
        document.documentElement.classList.toggle('modo-oscuro');
        const theme = document.documentElement.classList.contains('modo-oscuro') ? 'dark' : 'light';
        localStorage.setItem('theme', theme);
    });
});