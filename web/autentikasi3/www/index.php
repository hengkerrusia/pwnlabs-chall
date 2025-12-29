<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: /login.php");
}

require_once 'includes/header.php';
?>

<div class="container">
    <div class="dashboard-header">
        <h1>Welcome to SecureVault Dashboard</h1>
        <p class="subtitle">Your secure data management platform</p>
    </div>

    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon">📊</div>
            <div class="stat-content">
                <h3>Analytics</h3>
                <p class="stat-value">2,847</p>
                <p class="stat-label">Total Records</p>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon">🔒</div>
            <div class="stat-content">
                <h3>Security</h3>
                <p class="stat-value">Active</p>
                <p class="stat-label">Protection Status</p>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon">👥</div>
            <div class="stat-content">
                <h3>Users</h3>
                <p class="stat-value">156</p>
                <p class="stat-label">Active Sessions</p>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon">⚡</div>
            <div class="stat-content">
                <h3>Performance</h3>
                <p class="stat-value">99.8%</p>
                <p class="stat-label">Uptime</p>
            </div>
        </div>
    </div>

    <div class="admin-panel">
        <h2>🔐 Administrative Access</h2>
        <div class="admin-content">
            <p class="admin-info">System Configuration Key:</p>
            <div class="key-display">
                <code><?php echo htmlentities(getenv("FLAG")); ?></code>
            </div>
            <p class="admin-note">This key is required for system-level operations and configuration changes.</p>
        </div>
    </div>

    <div class="recent-activity">
        <h2>Recent Activity</h2>
        <div class="activity-list">
            <div class="activity-item">
                <span class="activity-time">2 minutes ago</span>
                <span class="activity-desc">Database backup completed successfully</span>
            </div>
            <div class="activity-item">
                <span class="activity-time">15 minutes ago</span>
                <span class="activity-desc">Security scan completed - No threats detected</span>
            </div>
            <div class="activity-item">
                <span class="activity-time">1 hour ago</span>
                <span class="activity-desc">System update applied</span>
            </div>
            <div class="activity-item">
                <span class="activity-time">3 hours ago</span>
                <span class="activity-desc">New user registration: john.doe@example.com</span>
            </div>
        </div>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>
