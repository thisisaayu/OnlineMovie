<?php
$pageTitle = 'Login';
include 'includes/db.php';
include 'includes/auth.php';
include 'includes/header.php';

// Already logged in — go home
if (isLoggedIn()) {
    header('Location: /OnlineMovie/index.php');
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $result = login($_POST['email'] ?? '', $_POST['password'] ?? '', $conn);

    if ($result === true) {
        // Redirect admin to dashboard, customers to homepage
        header('Location: ' . (isAdmin() ? '/OnlineMovie/Admin/dashboard.php' : '/OnlineMovie/index.php'));
        exit;
    } else {
        $error = $result;
    }
}
?>

<div class="auth-wrap">
    <div class="auth-card">

        <h1 class="auth-title">Welcome back</h1>
        <p class="auth-sub">Login to book your seats</p>

        <?php if ($error): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <form method="POST" action="login.php">

            <div class="form-group">
                <label for="email">Email</label>
                <input
                    type="email"
                    id="email"
                    name="email"
                    placeholder="you@example.com"
                    required
                    autocomplete="email"
                    value="<?= htmlspecialchars($_POST['email'] ?? '') ?>"
                >
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input
                    type="password"
                    id="password"
                    name="password"
                    placeholder="••••••••"
                    required
                    autocomplete="current-password"
                >
            </div>

            <button type="submit" class="btn btn-primary btn-block mt-2">Login</button>

        </form>

        <div class="auth-footer">
            Don't have an account? <a href="<?= $base ?>/register.php">Register</a>
        </div>

    </div>
</div>

<?php include 'includes/footer.php'; ?>