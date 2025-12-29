<?php
require_once 'config.php';

// Clear authentication cookie
clearAuthCookie();

// Redirect to home page
redirect('index.php');
