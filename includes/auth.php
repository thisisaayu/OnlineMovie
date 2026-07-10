<?php
// ============================================================
//  Auth Helpers
//  Every page that needs login protection includes this file.
//  It expects $conn from db.php, so always include db.php first.
// ============================================================

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


// ── Guards ───────────────────────────────────────────────────
// Drop either of these at the top of any page that needs protection.

// Redirect to login if not logged in at all
function requireLogin() {
    if (!isset($_SESSION['user_id'])) {
        header('Location: /OnlineMovie/login.php');
        exit;
    }
}

// Redirect to homepage if not an admin
function requireAdmin() {
    requireLogin();
    if ($_SESSION['role'] !== 'admin') {
        header('Location: /OnlineMovie/index.php');
        exit;
    }
}


// ── Checks ───────────────────────────────────────────────────

function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

function isAdmin() {
    return isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
}


// ── Login ────────────────────────────────────────────────────
// Returns true on success, or an error string on failure.

function login($email, $password, $conn) {
    $email = trim($email);

    if (empty($email) || empty($password)) {
        return 'Email and password are required.';
    }

    // Fetch user by email
    $stmt = mysqli_prepare($conn, "SELECT id, name, email, password, role FROM users WHERE email = ? AND is_active = 1 LIMIT 1");
    mysqli_stmt_bind_param($stmt, 's', $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $user   = mysqli_fetch_assoc($result);
    mysqli_stmt_close($stmt);

    if (!$user) {
        return 'No account found with that email.';
    }

    if (!password_verify($password, $user['password'])) {
        return 'Incorrect password.';
    }

    // Set session
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['name']    = $user['name'];
    $_SESSION['email']   = $user['email'];
    $_SESSION['role']    = $user['role'];

    return true;
}


// ── Register ─────────────────────────────────────────────────
// Returns true on success, or an error string on failure.

function register($name, $email, $phone, $password, $confirm, $conn) {
    $name  = trim($name);
    $email = trim($email);
    $phone = trim($phone);

    // Basic validation
    if (empty($name) || empty($email) || empty($password)) {
        return 'Name, email, and password are required.';
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return 'Please enter a valid email address.';
    }

    if (strlen($password) < 8) {
        return 'Password must be at least 8 characters.';
    }

    if ($password !== $confirm) {
        return 'Passwords do not match.';
    }

    // Check if email already exists
    $stmt = mysqli_prepare($conn, "SELECT id FROM users WHERE email = ? LIMIT 1");
    mysqli_stmt_bind_param($stmt, 's', $email);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);

    if (mysqli_stmt_num_rows($stmt) > 0) {
        mysqli_stmt_close($stmt);
        return 'An account with that email already exists.';
    }
    mysqli_stmt_close($stmt);

    // Hash password and insert
    $hashed = password_hash($password, PASSWORD_BCRYPT);

    $stmt = mysqli_prepare($conn, "INSERT INTO users (name, email, phone, password, role) VALUES (?, ?, ?, ?, 'customer')");
    mysqli_stmt_bind_param($stmt, 'ssss', $name, $email, $phone, $hashed);
    $ok = mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    if (!$ok) {
        return 'Registration failed. Please try again.';
    }

    return true;
}


// ── Logout ───────────────────────────────────────────────────

function logout() {
    session_unset();
    session_destroy();
    header('Location: /OnlineMovie/login.php');
    exit;
}