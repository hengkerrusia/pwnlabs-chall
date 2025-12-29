<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SecureVault - Data Management Platform</title>
    <link rel="stylesheet" href="/assets/css/style.css">
</head>
<body>
    <nav class="navbar">
        <div class="nav-container">
            <div class="nav-brand">
                <span class="brand-icon">🔐</span>
                <span class="brand-name">SecureVault</span>
            </div>
            <?php if (isset($_SESSION['username'])): ?>
            <div class="nav-menu">
                <a href="/index.php" class="nav-link">Dashboard</a>
                <a href="/logout.php" class="nav-link">Logout</a>
                <span class="nav-user">👤 <?php echo htmlentities($_SESSION['username']); ?></span>
            </div>
            <?php endif; ?>
        </div>
    </nav>
