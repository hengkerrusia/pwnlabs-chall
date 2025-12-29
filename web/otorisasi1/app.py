import os
from flask import Flask, render_template, request, redirect, url_for, session, flash
from models import init_db, get_session, User, Info

app = Flask(__name__)
app.secret_key = os.getenv('SESSION_SECRET', 'a1b2c3d4e5f6g7h8i9j0k1l2m3n4o5p6q7r8s9t0u1v2w3x4y5z6a7b8c9d0e1f2')

# Initialize database
database_url = os.getenv('DATABASE_URL', 'sqlite:///infovault.db')
engine = init_db(database_url)


def get_db_session():
    return get_session(engine)


def get_current_user():
    if 'user_id' in session:
        db_session = get_db_session()
        user = db_session.query(User).filter_by(id=session['user_id']).first()
        db_session.close()
        return user
    return None


def require_login():
    if not get_current_user():
        return redirect(url_for('login'))
    return None


@app.route('/')
def index():
    if get_current_user():
        return redirect(url_for('dashboard'))
    return redirect(url_for('login'))


@app.route('/login', methods=['GET', 'POST'])
def login():
    if get_current_user():
        return redirect(url_for('dashboard'))
    
    if request.method == 'POST':
        username = request.form.get('username')
        password = request.form.get('password')
        
        db_session = get_db_session()
        user = User.authenticate(db_session, username, password)
        db_session.close()
        
        if user:
            session['user_id'] = user.id
            return redirect(url_for('dashboard'))
        else:
            return render_template('login.html', error='Invalid username or password')
    
    return render_template('login.html', error=None)


@app.route('/register', methods=['GET', 'POST'])
def register():
    if get_current_user():
        return redirect(url_for('dashboard'))
    
    if request.method == 'POST':
        username = request.form.get('username')
        password = request.form.get('password')
        password_confirm = request.form.get('password_confirm')
        
        if password != password_confirm:
            return render_template('register.html', error='Passwords do not match')
        
        db_session = get_db_session()
        
        # Check if username exists
        if db_session.query(User).filter_by(username=username).first():
            db_session.close()
            return render_template('register.html', error='Username already exists')
        
        # Create new user
        user = User(username=username)
        user.set_password(password)
        db_session.add(user)
        db_session.commit()
        
        session['user_id'] = user.id
        db_session.close()
        
        return redirect(url_for('dashboard'))
    
    return render_template('register.html', error=None)


@app.route('/dashboard')
def dashboard():
    redirect_response = require_login()
    if redirect_response:
        return redirect_response
    
    current_user = get_current_user()
    db_session = get_db_session()
    
    # Get user's infos
    infos = db_session.query(Info).filter_by(user_id=current_user.id).order_by(Info.created_at.desc()).all()
    db_session.close()
    
    return render_template('dashboard.html', user=current_user, infos=infos)


@app.route('/info/<int:id>')
def info_detail(id):
    redirect_response = require_login()
    if redirect_response:
        return redirect_response
    
    current_user = get_current_user()
    db_session = get_db_session()
    
    # VULNERABILITY: No authorization check!
    # Should check: info.user_id == current_user.id
    info = db_session.query(Info).filter_by(id=id).first()
    
    if info:
        # Get the owner for display
        owner = db_session.query(User).filter_by(id=info.user_id).first()
        db_session.close()
        return render_template('info.html', info=info, owner=owner, current_user=current_user)
    else:
        db_session.close()
        return redirect(url_for('dashboard'))


@app.route('/new', methods=['GET', 'POST'])
def new_info():
    redirect_response = require_login()
    if redirect_response:
        return redirect_response
    
    current_user = get_current_user()
    
    if request.method == 'POST':
        title = request.form.get('title')
        details = request.form.get('details')
        
        db_session = get_db_session()
        info = Info(user_id=current_user.id, title=title, details=details)
        db_session.add(info)
        db_session.commit()
        db_session.close()
        
        return redirect(url_for('dashboard'))
    
    return render_template('new_info.html', error=None)


@app.route('/logout')
def logout():
    session.clear()
    return redirect(url_for('login'))


if __name__ == '__main__':
    app.run(host='0.0.0.0', port=4567, debug=True)
