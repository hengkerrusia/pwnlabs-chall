import sqlite3
from datetime import datetime

DATABASE = 'users.db'

def init_database():
    """Initialize the database with users table and sample data"""
    conn = sqlite3.connect(DATABASE)
    cursor = conn.cursor()
    
    # Drop existing table if it exists
    cursor.execute('DROP TABLE IF EXISTS users')
    
    # Create users table
    cursor.execute('''
        CREATE TABLE users (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            email TEXT NOT NULL UNIQUE,
            api_key TEXT NOT NULL,
            created_at TEXT NOT NULL,
            updated_at TEXT NOT NULL
        )
    ''')
    
    # Get current timestamp
    now = datetime.now().isoformat()
    
    # Insert sample users
    users = [
        ('admin@techcorp.internal', 'PwnLabs{j50n_3ndp01nt5_c4n_l34k_s3ns1t1v3_d4t4}', now, now),
        ('john.smith@techcorp.internal', 'tc_api_key_a8f3d9c2e1b4567890abcdef12345678', now, now),
        ('sarah.johnson@techcorp.internal', 'tc_api_key_b7e2c8d1f0a3456789bcdef0123456789', now, now),
        ('mike.wilson@techcorp.internal', 'tc_api_key_c6d1b7e0f9a2345678cdef01234567890', now, now),
        ('emma.davis@techcorp.internal', 'tc_api_key_d5c0a6f8e9b1234567def012345678901', now, now),
    ]
    
    cursor.executemany(
        'INSERT INTO users (email, api_key, created_at, updated_at) VALUES (?, ?, ?, ?)',
        users
    )
    
    conn.commit()
    conn.close()
    
    print("Database initialized successfully!")
    print(f"Created {len(users)} users")

if __name__ == '__main__':
    init_database()
