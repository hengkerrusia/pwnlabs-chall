#!/bin/sh
set -e

# Ensure data directory exists and has correct permissions
mkdir -p /var/www/data
chown -R www-data:www-data /var/www/data
chmod 755 /var/www/data

# Fix permissions for database file if it exists
if [ -f /var/www/data/secureauth.db ]; then
    chown www-data:www-data /var/www/data/secureauth.db
    chmod 664 /var/www/data/secureauth.db
fi

# Execute the main command
exec "$@"
