from flask import Flask, render_template, jsonify, request
import sqlite3
from datetime import datetime

app = Flask(__name__)
DATABASE = 'users.db'

def get_db():
    """Get database connection"""
    conn = sqlite3.connect(DATABASE)
    conn.row_factory = sqlite3.Row
    return conn

def get_user(user_id):
    """Fetch user by ID"""
    conn = get_db()
    user = conn.execute('SELECT * FROM users WHERE id = ?', (user_id,)).fetchone()
    conn.close()
    return user

@app.route('/')
def index():
    """Homepage listing all users"""
    conn = get_db()
    users = conn.execute('SELECT id, email FROM users ORDER BY id').fetchall()
    conn.close()
    return render_template('index.html', users=users)

@app.route('/users/<int:user_id>')
def show_user(user_id):
    """Show user details"""
    user = get_user(user_id)
    
    if not user:
        return "User not found", 404
    
    if 'application/json' in request.headers.get('Accept', ''):
        return jsonify(dict(user))
    
    return render_template('show.html', user=user)

@app.route('/users/<int:user_id>.json')
def show_user_json(user_id):
    """JSON API endpoint"""
    user = get_user(user_id)
    
    if not user:
        return jsonify({'error': 'User not found'}), 404
    
    return jsonify(dict(user))

if __name__ == '__main__':
    app.run(host='0.0.0.0', port=5000, debug=True)
