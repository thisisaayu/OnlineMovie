// CineBook — main.js

document.addEventListener('DOMContentLoaded', function () {

    // --- Theme toggle -----------------------------------
    const html        = document.documentElement;
    const toggleBtn   = document.getElementById('theme-toggle');
    const STORAGE_KEY = 'cinebook-theme';

    // Apply saved theme on load (default: dark)
    const savedTheme = localStorage.getItem(STORAGE_KEY) || 'dark';
    applyTheme(savedTheme);

    if (toggleBtn) {
        toggleBtn.addEventListener('click', function () {
            const current = html.getAttribute('data-theme') === 'light' ? 'light' : 'dark';
            const next    = current === 'dark' ? 'light' : 'dark';
            applyTheme(next);
            localStorage.setItem(STORAGE_KEY, next);
        });
    }

    function applyTheme(theme) {
        html.setAttribute('data-theme', theme);
        if (toggleBtn) {
            toggleBtn.textContent = theme === 'dark' ? '☀️' : '🌙';
            toggleBtn.title       = theme === 'dark' ? 'Switch to light mode' : 'Switch to dark mode';
        }
    }

    // --- Active nav link --------------------------------
    const path = window.location.pathname;
    document.querySelectorAll('.nav-link').forEach(function (link) {
        const href = link.getAttribute('href') || '';
        const page = href.split('/').pop();
        if (page && path.endsWith(page)) {
            link.classList.add('active');
        }
    });

    // --- Auto-dismiss alerts ----------------------------
    document.querySelectorAll('.alert').forEach(function (alert) {
        setTimeout(function () {
            alert.style.transition = 'opacity 0.4s';
            alert.style.opacity    = '0';
            setTimeout(function () { alert.remove(); }, 400);
        }, 4000);
    });

});