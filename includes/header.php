<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$base = '/OnlineMovie';
// ─────────────────────────────────────────────────────────────
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= isset($pageTitle) ? htmlspecialchars($pageTitle) . ' — CineBook' : 'CineBook' ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= $base ?>/Assets/Css/style.css">
</head>
<body>

<nav class="navbar">
    <div class="nav-inner">

        <a href="<?= $base ?>/index.php" class="nav-logo">Cine<span>Book</span></a>

        <div class="nav-right">
        <ul class="nav-links">
            <li><a href="<?= $base ?>/index.php" class="nav-link">Home</a></li>

            <?php if (isset($_SESSION['user_id'])): ?>

                <?php if ($_SESSION['role'] === 'admin'): ?>
                    <li><a href="<?= $base ?>/Admin/dashboard.php" class="nav-link">Dashboard</a></li>
                    <li><a href="<?= $base ?>/Admin/movies.php"    class="nav-link">Movies</a></li>
                    <li><a href="<?= $base ?>/Admin/shows.php"     class="nav-link">Shows</a></li>
                    <li><a href="<?= $base ?>/Admin/reports.php"   class="nav-link">Reports</a></li>
                <?php else: ?>
                    <li><a href="<?= $base ?>/index.php"           class="nav-link">Movies</a></li>
                    <li><a href="<?= $base ?>/User/history.php"    class="nav-link">My Bookings</a></li>
                <?php endif; ?>

                <li class="nav-user">
                    <span class="user-badge"><?= htmlspecialchars($_SESSION['name']) ?></span>
                    <a href="<?= $base ?>/logout.php" class="btn btn-ghost btn-sm">Logout</a>
                </li>

            <?php else: ?>
                <li><a href="<?= $base ?>/index.php"    class="nav-link">Movies</a></li>
                <li><a href="<?= $base ?>/login.php"    class="btn btn-ghost btn-sm">Login</a></li>
                <li><a href="<?= $base ?>/register.php" class="btn btn-primary btn-sm">Register</a></li>
            <?php endif; ?>
        </ul>

        <button class="theme-toggle" id="theme-toggle" title="Toggle theme">🌙</button>
        </div>

    </div>
</nav>

<main class="main">