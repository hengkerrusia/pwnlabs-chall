<?php
// Database configuration
define('DB_PATH', '/var/www/data/secureauth.db');

// Secret key for XOR decryption (must match the key in flag_encoder.php)
define('XOR_KEY', 'S3cur3Auth_K3y_2024!@#');

/**
 * XOR decrypt a string with a key (XOR is symmetric, so encrypt = decrypt)
 */
function xor_decrypt($data, $key) {
    $output = '';
    $keyLength = strlen($key);
    $dataLength = strlen($data);
    
    for ($i = 0; $i < $dataLength; $i++) {
        $output .= $data[$i] ^ $key[$i % $keyLength];
    }
    
    return $output;
}

// Decode obfuscated flag (Base64 -> Base64 -> XOR decrypt)
$flagObfuscated = getenv('FLAG_OBFUSCATED') ?: 'RXhrT0UzZ3daUU9lWkdBc0FVSTBuUzhrcDE5aFpVRXNwbUF3cUtWbUttRTBLbUVmb1UwPQ==';

// Layer 1: Base64 decode (outer layer)
$base64_once = base64_decode($flagObfuscated);

// Layer 2: Base64 decode (inner layer)
$xored = base64_decode($base64_once);

// Layer 3: XOR decrypt
$flag = xor_decrypt($xored, XOR_KEY);

define('FLAG', $flag);

// Cookie configuration
define('AUTH_COOKIE', 'auth');
define('COOKIE_LIFETIME', 86400); // 24 hours

// Database connection
function getDB() {
    static $pdo = null;
    
    if ($pdo === null) {
        try {
            // Create data directory if it doesn't exist
            $dataDir = dirname(DB_PATH);
            if (!is_dir($dataDir)) {
                mkdir($dataDir, 0755, true);
            }
            
            $isNewDb = !file_exists(DB_PATH);
            
            $pdo = new PDO(
                "sqlite:" . DB_PATH,
                null,
                null,
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    PDO::ATTR_EMULATE_PREPARES => false
                ]
            );
            
            // Initialize database if it's new
            if ($isNewDb) {
                initializeDatabase($pdo);
            }
        } catch (PDOException $e) {
            die("Database connection failed: " . $e->getMessage());
        }
    }
    
    return $pdo;
}

// Initialize database schema and default data
function initializeDatabase($pdo) {
    // Create users table
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS users (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            username TEXT UNIQUE NOT NULL,
            password TEXT NOT NULL,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP
        )
    ");
    
    // Insert default admin user
    $adminPassword = password_hash('admin123', PASSWORD_BCRYPT);
    $pdo->exec("
        INSERT INTO users (username, password) 
        VALUES ('admin', '$adminPassword')
    ");
}

// Get current user from cookie
function getCurrentUser() {
    if (!isset($_COOKIE[AUTH_COOKIE])) {
        return null;
    }
    
    // Decode the cookie value (base64 encoded username)
    $username = base64_decode($_COOKIE[AUTH_COOKIE]);
    
    if (empty($username)) {
        return null;
    }
    
    return $username;
}

// Set authentication cookie
function setAuthCookie($username) {
    // Encode username in base64
    $cookieValue = base64_encode($username);
    setcookie(AUTH_COOKIE, $cookieValue, time() + COOKIE_LIFETIME, '/');
}

// Clear authentication cookie
function clearAuthCookie() {
    setcookie(AUTH_COOKIE, '', time() - 3600, '/');
}

// Check if user is authenticated
function isAuthenticated() {
    return getCurrentUser() !== null;
}

// Redirect helper
function redirect($url) {
    header("Location: $url");
    exit;
}

// HTML escape helper
function e($string) {
    return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
}
