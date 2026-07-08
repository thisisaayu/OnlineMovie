// CineBook — main.js
// Core functionality is PHP. This file handles minor UI enhancements only.

document.addEventListener('DOMContentLoaded', function () {

    // Mark the current page's nav link as active
    const path = window.location.pathname;
    document.querySelectorAll('.nav-link').forEach(function (link) {
        const href = link.getAttribute('href') || '';
        const page = href.split('/').pop();
        if (page && path.endsWith(page)) {
            link.classList.add('active');
        }
    });

    // Auto-dismiss alerts after 4 seconds
    document.querySelectorAll('.alert').forEach(function (alert) {
        setTimeout(function () {
            alert.style.transition = 'opacity 0.4s';
            alert.style.opacity    = '0';
            setTimeout(function () { alert.remove(); }, 400);
        }, 4000);
    });

});