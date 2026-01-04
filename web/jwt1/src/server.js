const express = require('express');
const sqlite3 = require('sqlite3').verbose();
const bcrypt = require('bcryptjs');
const jwt = require('jsonwebtoken');
const bodyParser = require('body-parser');
const cookieParser = require('cookie-parser');
const path = require('path');

const app = express();
const PORT = 3000;
const JWT_SECRET = 'sup3r_s3cr3t_k3y_f0r_jwt_t0k3ns_2025';

app.use(bodyParser.json());
app.use(bodyParser.urlencoded({ extended: true }));
app.use(cookieParser());
app.use(express.static('public'));

const db = new sqlite3.Database('./database.db', (err) => {
    if (err) {
        console.error('Database connection error:', err.message);
    } else {
        console.log('Connected to SQLite database');
    }
});

db.serialize(() => {
    db.run(`CREATE TABLE IF NOT EXISTS users (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    username TEXT UNIQUE NOT NULL,
    password TEXT NOT NULL,
    role TEXT DEFAULT 'user'
  )`);

    const adminPassword = bcrypt.hashSync('admin@2025!SecureVault', 10);
    db.run(`INSERT OR IGNORE INTO users (username, password, role) VALUES (?, ?, ?)`,
        ['admin', adminPassword, 'admin']);
});

function verifyToken(req, res, next) {
    const token = req.cookies.auth_token;

    if (!token) {
        return res.status(401).json({ error: 'No token provided' });
    }

    try {
        const decoded = jwt.decode(token, { complete: true });

        if (!decoded) {
            return res.status(401).json({ error: 'Invalid token' });
        }

        if (decoded.header.alg === 'none') {
            req.user = decoded.payload;
            return next();
        }

        jwt.verify(token, JWT_SECRET, (err, user) => {
            if (err) {
                return res.status(403).json({ error: 'Invalid or expired token' });
            }
            req.user = user;
            next();
        });
    } catch (error) {
        return res.status(401).json({ error: 'Token verification failed' });
    }
}

function requireAdmin(req, res, next) {
    if (req.user.login !== 'admin') {
        return res.status(403).json({ error: 'Admin access required' });
    }
    next();
}

app.post('/api/register', async (req, res) => {
    const { username, password } = req.body;

    if (!username || !password) {
        return res.status(400).json({ error: 'Username and password are required' });
    }

    if (username === 'admin') {
        return res.status(400).json({ error: 'Username is already taken' });
    }

    if (password.length < 6) {
        return res.status(400).json({ error: 'Password must be at least 6 characters' });
    }

    const hashedPassword = await bcrypt.hash(password, 10);

    db.run('INSERT INTO users (username, password, role) VALUES (?, ?, ?)',
        [username, hashedPassword, 'user'],
        function (err) {
            if (err) {
                if (err.message.includes('UNIQUE constraint failed')) {
                    return res.status(400).json({ error: 'Username is already taken' });
                }
                return res.status(500).json({ error: 'Registration failed' });
            }

            const token = jwt.sign(
                { login: username, iat: Math.floor(Date.now() / 1000) },
                JWT_SECRET,
                { algorithm: 'HS256' }
            );

            res.cookie('auth_token', token, { httpOnly: true });
            res.json({ message: 'Registration successful', username });
        }
    );
});

app.post('/api/login', (req, res) => {
    const { username, password } = req.body;

    if (!username || !password) {
        return res.status(400).json({ error: 'Username and password are required' });
    }

    db.get('SELECT * FROM users WHERE username = ?', [username], async (err, user) => {
        if (err) {
            return res.status(500).json({ error: 'Login failed' });
        }

        if (!user) {
            return res.status(401).json({ error: 'Invalid credentials' });
        }

        const validPassword = await bcrypt.compare(password, user.password);
        if (!validPassword) {
            return res.status(401).json({ error: 'Invalid credentials' });
        }

        const token = jwt.sign(
            { login: username, iat: Math.floor(Date.now() / 1000) },
            JWT_SECRET,
            { algorithm: 'HS256' }
        );

        res.cookie('auth_token', token, { httpOnly: true });
        res.json({ message: 'Login successful', username });
    });
});

app.get('/api/profile', verifyToken, (req, res) => {
    res.json({
        username: req.user.login,
        message: 'User profile retrieved successfully'
    });
});

app.get('/api/admin/stats', verifyToken, requireAdmin, (req, res) => {
    res.json({
        systemVersion: '2.4.1',
        totalUsers: 127,
        activeConnections: 18,
        storageUsed: '45.2 GB',
        uptime: '23 days'
    });
});

app.get('/api/admin/documents', verifyToken, requireAdmin, (req, res) => {
    res.json([
        {
            id: 1,
            name: 'System Configuration.txt',
            type: 'config',
            size: '2.4 KB',
            modified: '2025-01-15',
            restricted: true
        },
        {
            id: 2,
            name: 'API Keys & Tokens.txt',
            type: 'credentials',
            size: '1.8 KB',
            modified: '2025-01-10',
            restricted: true
        },
        {
            id: 3,
            name: 'Security Audit Log.txt',
            type: 'log',
            size: '15.3 KB',
            modified: '2025-01-18',
            restricted: true
        },
        {
            id: 4,
            name: 'Database Backup Settings.txt',
            type: 'config',
            size: '3.1 KB',
            modified: '2025-01-12',
            restricted: true
        }
    ]);
});

app.get('/api/admin/documents/:id', verifyToken, requireAdmin, (req, res) => {
    const documentId = parseInt(req.params.id);

    const documents = {
        1: {
            name: 'System Configuration.txt',
            content: `SecureVault System Configuration
================================

Server Configuration:
- Host: securevault.internal
- Port: 3000
- Environment: Production
- Node Version: 18.x
- Database: SQLite 3.x

Security Settings:
- JWT Algorithm: HS256
- Session Timeout: 24 hours
- Password Min Length: 6 characters
- Max Login Attempts: 5

API Configuration:
- Rate Limiting: 100 requests/minute
- CORS: Disabled
- Request Size Limit: 10MB

Backup Schedule:
- Daily: 02:00 UTC
- Weekly: Sunday 03:00 UTC
- Retention: 30 days

Last Updated: 2025-01-15
Administrator: SecureVault Team`
        },
        2: {
            name: 'API Keys & Tokens.txt',
            content: `API Keys and Access Tokens
==========================

Production API Key:
sk_love_51JKxYzP2FqG3mN8vH7cR9dT4wL2eQ6bX3nA1sK5fY8uV7jZ4pM3rC2hN9gB6wX

Development API Key:
sk_love_4eC39HqLyjWDarjtT1zdp7dc

System Access Token (CTF Flag):
PwnLabs{jwt_n0n3_alg0r1thm_byp4ss}

OAuth2 Credentials:
- Client ID: securevault-prod-2025
- Client Secret: [REDACTED]

Third-Party Integration Keys:
- AWS Access Key: AKIA****************
- Stripe API Key: sk_live_****************
- SendGrid API Key: SG.******************

IMPORTANT: Keep these credentials secure and rotate regularly.
Last Rotation: 2025-01-10
Next Rotation: 2025-04-10

Contact security@securevault.internal for key rotation requests.`
        },
        3: {
            name: 'Security Audit Log.txt',
            content: `Security Audit Log - January 2025
==================================

[2025-01-18 14:32:15] ADMIN_LOGIN - User: admin - IP: 192.168.1.100
[2025-01-18 14:28:03] FAILED_LOGIN - User: admin - IP: 203.0.113.45
[2025-01-18 14:27:58] FAILED_LOGIN - User: admin - IP: 203.0.113.45
[2025-01-18 12:15:22] USER_CREATED - Username: john_doe - Admin: admin
[2025-01-18 11:45:33] CONFIG_CHANGED - Setting: max_upload_size - Admin: admin
[2025-01-17 09:22:14] ADMIN_LOGIN - User: admin - IP: 192.168.1.100
[2025-01-17 08:55:41] BACKUP_COMPLETED - Size: 2.4GB - Status: Success
[2025-01-16 16:34:28] USER_DELETED - Username: test_user_old - Admin: admin
[2025-01-16 14:21:09] ADMIN_LOGIN - User: admin - IP: 192.168.1.100
[2025-01-15 22:18:47] SYSTEM_UPDATE - Version: 2.4.0 -> 2.4.1 - Admin: admin
[2025-01-15 18:44:52] PASSWORD_CHANGED - User: admin - IP: 192.168.1.100
[2025-01-15 10:33:21] ADMIN_LOGIN - User: admin - IP: 192.168.1.100

Audit Retention Policy: 90 days
Export Format: JSON, CSV available on request

For detailed logs, contact: security@securevault.internal`
        },
        4: {
            name: 'Database Backup Settings.txt',
            content: `Database Backup Configuration
=============================

Backup Strategy:
- Type: Incremental + Full Weekly
- Storage: AWS S3 + Local NAS
- Encryption: AES-256
- Compression: gzip

Schedule:
Monday-Saturday: Incremental (Daily 02:00 UTC)
Sunday: Full Backup (03:00 UTC)

Retention Policy:
- Daily Backups: 7 days
- Weekly Backups: 4 weeks
- Monthly Backups: 12 months

Storage Locations:
Primary:   s3://securevault-backups/production/
Secondary: /mnt/nas/backups/securevault/

Backup Verification:
- Integrity Check: Daily
- Restore Test: Weekly (Test Environment)
- Recovery Time Objective (RTO): 4 hours
- Recovery Point Objective (RPO): 24 hours

Alert Recipients:
- admin@securevault.internal
- operations@securevault.internal

Last Full Backup: 2025-01-14 03:00 UTC
Last Successful Restore Test: 2025-01-13
Backup Status: Healthy

Configuration Last Updated: 2025-01-12
Next Review Date: 2025-04-12`
        }
    };

    const document = documents[documentId];

    if (!document) {
        return res.status(404).json({ error: 'Document not found' });
    }

    res.json(document);
});

app.post('/api/logout', (req, res) => {
    res.clearCookie('auth_token');
    res.json({ message: 'Logged out successfully' });
});

app.listen(PORT, '0.0.0.0', () => {
    console.log(`SecureVault server running on http://0.0.0.0:${PORT}`);
});
