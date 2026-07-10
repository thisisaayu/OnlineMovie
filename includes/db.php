<?php
// ============================================================
//  Database Connection
//  Edit the four constants below to match your setup.
// ============================================================

define('DB_HOST', 'localhost');
define('DB_USER', 'root');       // default XAMPP user
define('DB_PASS', '');           // default XAMPP password (empty)
define('DB_NAME', 'onlinemovie');

$conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if (!$conn) {
    die('Database connection failed: ' . mysqli_connect_error());
}

// Use UTF-8 for everything
mysqli_set_charset($conn, 'utf8mb4');