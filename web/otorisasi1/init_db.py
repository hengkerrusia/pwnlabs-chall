#!/usr/bin/env python3
import os
from models import init_db, get_session, User, Info

def seed_database():
    database_url = os.getenv('DATABASE_URL', 'sqlite:///infovault.db')
    engine = init_db(database_url)
    session = get_session(engine)
    
    # Check if database is already seeded
    if session.query(User).count() > 0:
        print("Database already seeded, skipping...")
        session.close()
        return
    
    print("Seeding database...")
    
    # Create user1
    user1 = User(username='user1')
    user1.set_password('password123')
    session.add(user1)
    session.flush()  # Get user1.id
    
    # Create user1's infos
    info1 = Info(
        user_id=user1.id,
        title='Personal Notes',
        details='Remember to update the project documentation by end of week.'
    )
    info2 = Info(
        user_id=user1.id,
        title='Meeting Summary',
        details='Discussed Q4 objectives with the team. Action items: review budget, finalize timeline.'
    )
    session.add(info1)
    session.add(info2)
    
    # Create admin
    admin = User(username='admin')
    admin.set_password('adminpass')
    session.add(admin)
    session.flush()  # Get admin.id
    
    # Create admin's info with flag
    admin_info = Info(
        user_id=admin.id,
        title='System Configuration',
        details='PwnLabs{1d0r_4cc3ss_c0ntr0l_f41l}'
    )
    session.add(admin_info)
    
    session.commit()
    print("Database seeded successfully!")
    print("Users created: user1, admin")
    session.close()

if __name__ == '__main__':
    seed_database()
