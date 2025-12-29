<?php
require_once 'config.php';

// Redirect if already authenticated
if (isAuthenticated()) {
    redirect('dashboard.php');
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SecureAuth Portal - Enterprise Authentication System</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h1>🔐 SecureAuth Portal</h1>
                <p>Enterprise-Grade Authentication System</p>
            </div>
            <div class="card-body">
                <div class="hero">
                    <h1>Welcome to SecureAuth</h1>
                    <p>
                        A modern, secure authentication platform designed for enterprise applications.
                        Our system provides robust user management and access control for your organization.
                    </p>
                    <div class="button-group">
                        <a href="login.php" class="btn btn-primary">Login</a>
                        <a href="register.php" class="btn btn-secondary">Create Account</a>
                    </div>
                </div>
                
                <div class="stats-grid">
                    <div class="stat-card">
                        <h4>Secure</h4>
                        <p>🛡️</p>
                    </div>
                    <div class="stat-card">
                        <h4>Fast</h4>
                        <p>⚡</p>
                    </div>
                    <div class="stat-card">
                        <h4>Reliable</h4>
                        <p>✓</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
