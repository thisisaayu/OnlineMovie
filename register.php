<?php
$pageTitle = 'Register';
include 'includes/header.php';
// TODO: include 'includes/db.php';
// TODO: include 'includes/auth.php'; 

// TODO: handle form submission
// if ($_SERVER['REQUEST_METHOD'] === 'POST') {
//     $name     = trim($_POST['name']);
//     $email    = trim($_POST['email']);
//     $phone    = trim($_POST['phone']);
//     $password = $_POST['password'];
//     $confirm  = $_POST['confirm_password'];
//     register($name, $email, $phone, $password, $confirm, $conn);
// }

$error   = '';
$success = '';
?>

<div class="auth-wrap">
    <div class="auth-card">

        <h1 class="auth-title">Create account</h1>
        <p class="auth-sub">Register to start booking tickets</p>

        <?php if ($error): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <?php if ($success): ?>
            <div class="alert alert-success"><?= htmlspecialchars($success) ?></div>
        <?php endif; ?>

        <form method="POST" action="register.php">

            <div class="form-group">
                <label for="name">Full Name</label>
                <input
                    type="text"
                    id="name"
                    name="name"
                    placeholder="Your name here.."
                    required
                    autocomplete="name"
                    value="<?= htmlspecialchars($_POST['name'] ?? '') ?>"
                >
            </div>

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
                <label for="phone">Phone <span class="text-dim">(optional)</span></label>
                <input
                    type="tel"
                    id="phone"
                    name="phone"
                    placeholder="98XXXXXXXX"
                    autocomplete="tel"
                    value="<?= htmlspecialchars($_POST['phone'] ?? '') ?>"
                >
            </div>

            <hr class="form-divider">

            <div class="form-group">
                <label for="password">Password</label>
                <input
                    type="password"
                    id="password"
                    name="password"
                    placeholder="••••••••"
                    required
                    autocomplete="new-password"
                >
                <p class="form-hint">At least 8 characters</p>
            </div>

            <div class="form-group">
                <label for="confirm_password">Confirm Password</label>
                <input
                    type="password"
                    id="confirm_password"
                    name="confirm_password"
                    placeholder="••••••••"
                    required
                    autocomplete="new-password"
                >
            </div>

            <button type="submit" class="btn btn-primary btn-block mt-2">Create Account</button>

        </form>

        <div class="auth-footer">
            Already have an account? <a href="<?= $base ?>/login.php">Login</a>
        </div>

    </div>
</div>

<?php include 'includes/footer.php'; ?>