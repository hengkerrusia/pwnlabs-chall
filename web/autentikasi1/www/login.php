<?php
require_once 'config.php';

$error = '';

// Redirect if already authenticated
if (isAuthenticated()) {
    redirect('dashboard.php');
}

// Handle login
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    
    if (empty($username) || empty($password)) {
        $error = 'Username and password are required.';
    } else {
        try {
            $db = getDB();
            
            // Get user from database
            $stmt = $db->prepare("SELECT username, password FROM users WHERE username = ?");
            $stmt->execute([$username]);
            $user = $stmt->fetch();
            
            if ($user && password_verify($password, $user['password'])) {
                // VULNERABILITY: Set cookie with base64-encoded username
                // No signature, no encryption, just base64 encoding
                setAuthCookie($user['username']);
                redirect('dashboard.php');
            } else {
                $error = 'Invalid username or password.';
            }
        } catch (PDOException $e) {
            $error = 'Login failed. Please try again.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SecureAuth Portal</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <div class="card" style="max-width: 500px; margin: 0 auto;">
            <div class="card-header">
                <h1>🔐 SecureAuth Portal</h1>
                <p>Login to Your Account</p>
            </div>
            <div class="card-body">
                <?php if ($error): ?>
                    <div class="alert alert-error"><?php echo e($error); ?></div>
                <?php endif; ?>
                
                <form method="POST" action="">
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input 
                            type="text" 
                            id="username" 
                            name="username" 
                            class="form-control" 
                            required
                            value="<?php echo e($_POST['username'] ?? ''); ?>"
                            autocomplete="username"
                        >
                    </div>
                    
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input 
                            type="password" 
                            id="password" 
                            name="password" 
                            class="form-control" 
                            required
                            autocomplete="current-password"
                        >
                    </div>
                    
                    <button type="submit" class="btn btn-primary">Login</button>
                </form>
                
                <div class="text-center mt-3">
                    <p>Don't have an account? <a href="register.php" class="link">Register here</a></p>
                    <p><a href="index.php" class="link">← Back to Home</a></p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
