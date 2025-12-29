<?php
session_start();

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    
    if ($username === 'admin' && $password === 'admin123') {
        $_SESSION['username'] = $username;
        header("Location: /index.php");
        exit;
    } else {
        $error = 'Invalid username or password';
    }
}

require_once 'includes/header.php';
?>

<div class="login-container">
    <div class="login-box">
        <div class="login-header">
            <h1>SecureVault</h1>
            <p>Sign in to your account</p>
        </div>

        <?php if ($error): ?>
        <div class="error-message">
            <?php echo htmlentities($error); ?>
        </div>
        <?php endif; ?>

        <form method="POST" action="/login.php" class="login-form">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" required autocomplete="username">
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required autocomplete="current-password">
            </div>

            <button type="submit" class="btn-primary">Sign In</button>
        </form>

    </div>
</div>

<?php require_once 'includes/footer.php'; ?>
