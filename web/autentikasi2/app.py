from flask import Flask, render_template, request, session, redirect, url_for
import sqlite3
import hashlib
import os
from datetime import datetime

app = Flask(__name__)
app.secret_key = os.environ.get('SESSION_SECRET') or os.urandom(32).hex()

# Configuration
DATABASE = 'auth.db'
SEED = os.environ.get('SECRET_SEED', 's3cr3t_s33d_2024')
ADMIN_PASSWORD = os.environ.get('ADMIN_PASSWORD', 'sup3r_s3cr3t_adm1n')
FLAG = os.environ.get('FLAG', 'PwnLabs{c4s3_1ns3ns1t1v3_c0ll4t10n_byp4ss}')

def get_db():
    """Get database connection"""
    conn = sqlite3.connect(DATABASE)
    conn.row_factory = sqlite3.Row
    return conn

def init_db():
    """Initialize database and create admin user"""
    conn = get_db()
    cursor = conn.cursor()
    
    cursor.execute('''
        CREATE TABLE IF NOT EXISTS users (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            username TEXT COLLATE NOCASE NOT NULL,
            password TEXT NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )
    ''')
    
    cursor.execute('SELECT * FROM users WHERE username = ? COLLATE NOCASE', ('admin',))
    if not cursor.fetchone():
        # Create admin user
        hashed_password = hashlib.md5(f"{SEED}{ADMIN_PASSWORD}{SEED}".encode()).hexdigest()
        cursor.execute('INSERT INTO users (username, password) VALUES (?, ?)', 
                      ('admin', hashed_password))
        conn.commit()
    
    conn.close()

# Initialize database on startup
init_db()

@app.route('/')
def index():
    """Main page - dashboard or redirect to login"""
    # Check if user is already logged in
    if session.get('user'):
        conn = get_db()
        cursor = conn.cursor()
        cursor.execute('SELECT * FROM users WHERE username = ? COLLATE NOCASE', (session['user'],))
        user = cursor.fetchone()
        conn.close()
        
        if user:
            return render_template('index.html', user=dict(user), flag=FLAG)
    
    # Show login page
    return render_template('login.html')

@app.route('/login', methods=['GET', 'POST'])
def login():
    """Handle login authentication"""
    if request.method == 'POST':
        username = request.form.get('username')
        password = request.form.get('password')
        
        # Hash password with seed
        hashed_password = hashlib.md5(f"{SEED}{password}{SEED}".encode()).hexdigest()
        
        # Query database - NOCASE collation makes this case-insensitive
        conn = get_db()
        cursor = conn.cursor()
        cursor.execute('SELECT * FROM users WHERE username = ? AND password = ? COLLATE NOCASE', 
                      (username, hashed_password))
        user = cursor.fetchone()
        conn.close()
        
        if user:
            # Store the username from database (enables session hijacking!)
            session['user'] = user['username']
            return redirect(url_for('index'))
        else:
            return render_template('login.html', error='Invalid username or password')
    
    # GET request - show login page
    return render_template('login.html')

@app.route('/signup', methods=['GET', 'POST'])
def signup():
    """User registration"""
    if request.method == 'POST':
        username = request.form.get('username')
        password = request.form.get('password')
        
        conn = get_db()
        cursor = conn.cursor()
        
        # Get all users and check manually (case-sensitive in Python!)
        cursor.execute('SELECT * FROM users')
        users = cursor.fetchall()
        
        # Case-sensitive check in Python
        existing = [u for u in users if u['username'] == username]
        
        if len(existing) > 0:
            conn.close()
            return render_template('signup.html', error='User already exists')
        
        # Create new user
        hashed_password = hashlib.md5(f"{SEED}{password}{SEED}".encode()).hexdigest()
        cursor.execute('INSERT INTO users (username, password) VALUES (?, ?)', 
                      (username, hashed_password))
        conn.commit()
        
        # Get the created user
        cursor.execute('SELECT * FROM users WHERE id = ?', (cursor.lastrowid,))
        user = cursor.fetchone()
        conn.close()
        
        # Store username from database in session
        session['user'] = user['username']
        
        return redirect(url_for('index'))
    
    return render_template('signup.html')

@app.route('/logout')
def logout():
    """Logout user"""
    session.clear()
    return redirect(url_for('index'))

if __name__ == '__main__':
    app.run(host='0.0.0.0', port=5000, debug=False)
