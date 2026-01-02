#!/bin/bash

# Create uploads directory if it doesn't exist
mkdir -p /var/www/html/uploads
chown -R www-data:www-data /var/www/html/uploads
chmod -R 755 /var/www/html/uploads

# Start Apache in foreground
apache2-foreground
