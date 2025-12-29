<?php
require_once 'config.php';

// Check authentication
if (!isAuthenticated()) {
    redirect('login.php');
}

$currentUser = getCurrentUser();
$isAdmin = ($currentUser === 'admin');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - SecureAuth Portal</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <div class="card">
            <div class="card-header">
                <h1>🔐 SecureAuth Portal</h1>
                <p>User Dashboard</p>
            </div>
            <div class="card-body">
                <div class="dashboard-header">
                    <h2>Welcome, <?php echo e($currentUser); ?>!</h2>
                    <a href="logout.php" class="btn btn-danger">Logout</a>
                </div>
                
                <div class="user-info">
                    <h3>Account Information</h3>
                    <p><strong>Username:</strong> <?php echo e($currentUser); ?></p>
                    <p><strong>Role:</strong> <?php echo $isAdmin ? 'Administrator' : 'Standard User'; ?></p>
                    <p><strong>Status:</strong> <span style="color: #10b981;">● Active</span></p>
                </div>
                
                <?php if ($isAdmin): ?>
                    <!-- Admin-only content -->
                    <div class="alert alert-info">
                        <strong>🎯 Administrator Access Granted</strong><br>
                        You have full administrative privileges on this system.
                    </div>
                    
                    <div class="flag-container">
                        <h3>🏆 System Access Key</h3>
                        <div class="flag-value">
                            <?php echo e(FLAG); ?>
                        </div>
                    </div>
                    
                    <div class="stats-grid">
                        <div class="stat-card">
                            <h4>Total Users</h4>
                            <p>
                                <?php
                                try {
                                    $db = getDB();
                                    $stmt = $db->query("SELECT COUNT(*) as count FROM users");
                                    $result = $stmt->fetch();
                                    echo $result['count'];
                                } catch (PDOException $e) {
                                    echo 'N/A';
                                }
                                ?>
                            </p>
                        </div>
                        <div class="stat-card">
                            <h4>System Status</h4>
                            <p style="color: #10b981;">Online</p>
                        </div>
                        <div class="stat-card">
                            <h4>Security Level</h4>
                            <p style="color: #fbbf24;">Medium</p>
                        </div>
                    </div>
                <?php else: ?>
                    <!-- Regular user content -->
                    <div class="alert alert-info">
                        <strong>Welcome to SecureAuth Portal!</strong><br>
                        Your account has been successfully authenticated. You can now access your personalized dashboard and manage your profile settings.
                    </div>
                    
                    <div class="stats-grid">
                        <div class="stat-card">
                            <h4>Account Type</h4>
                            <p>Standard</p>
                        </div>
                        <div class="stat-card">
                            <h4>Login Status</h4>
                            <p style="color: #10b981;">Active</p>
                        </div>
                        <div class="stat-card">
                            <h4>Access Level</h4>
                            <p>User</p>
                        </div>
                    </div>
                    
                    <div class="user-info" style="margin-top: 30px;">
                        <h3>📋 Available Features</h3>
                        <p>• View your account information</p>
                        <p>• Update your profile settings</p>
                        <p>• Manage your preferences</p>
                        <p>• Access standard user resources</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>
</html>
