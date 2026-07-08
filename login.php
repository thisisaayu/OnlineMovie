<?php
$pageTitle = 'Login';
include 'includes/header.php';
// TODO: include 'includes/db.php';
// TODO: include 'includes/auth.php';

// TODO: handle form submission
// if ($_SERVER['REQUEST_METHOD'] === 'POST') {
//     $email    = trim($_POST['email']);
//     $password = $_POST['password'];
//     login($email, $password, $conn);
// }

$error = ''; // will be set by auth logic later
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