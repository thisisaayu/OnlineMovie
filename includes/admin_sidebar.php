<div class="admin-sidebar">
    <p class="admin-sidebar-title">Admin Panel</p>

    <a href="<?= $base ?>/admin/dashboard.php"
       class="admin-nav-link <?= basename($_SERVER['PHP_SELF']) === 'dashboard.php' ? 'active' : '' ?>">
        Dashboard
    </a>
    <a href="<?= $base ?>/admin/movies.php"
       class="admin-nav-link <?= basename($_SERVER['PHP_SELF']) === 'movies.php' ? 'active' : '' ?>">
        Movies
    </a>
    <a href="<?= $base ?>/admin/halls.php"
       class="admin-nav-link <?= basename($_SERVER['PHP_SELF']) === 'halls.php' ? 'active' : '' ?>">
        Halls
    </a>
    <a href="<?= $base ?>/admin/shows.php"
       class="admin-nav-link <?= basename($_SERVER['PHP_SELF']) === 'shows.php' ? 'active' : '' ?>">
        Shows
    </a>
    <a href="<?= $base ?>/admin/reports.php"
       class="admin-nav-link <?= basename($_SERVER['PHP_SELF']) === 'reports.php' ? 'active' : '' ?>">
        Reports
    </a>

    <hr class="divider" style="margin: 16px 20px;">

    <a href="<?= $base ?>/logout.php" class="admin-nav-link text-danger">
        Logout
    </a>
</div>