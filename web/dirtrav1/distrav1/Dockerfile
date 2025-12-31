FROM php:8.2-apache

# Install SQLite3
RUN apt-get update && apt-get install -y \
    sqlite3 \
    libsqlite3-dev \
    && docker-php-ext-install pdo pdo_sqlite \
    && rm -rf /var/lib/apt/lists/*

# Enable Apache modules
RUN a2enmod rewrite

# Create upload directory
RUN mkdir -p /var/www/uploads && \
    chown -R www-data:www-data /var/www/uploads && \
    chmod -R 755 /var/www/uploads

# Add flag to /etc/passwd (append to existing file)
RUN echo "# PwnLabs{d1r3ct0ry_tr4v3rs4l_vuln}" >> /etc/passwd

# Copy sample images
COPY src/uploads/*.jpg /var/www/uploads/

# Set working directory
WORKDIR /var/www/html

# Copy application files
COPY src/ /var/www/html/

# Create database directory with proper permissions
RUN mkdir -p /var/www/data && \
    chown -R www-data:www-data /var/www/data && \
    chmod -R 755 /var/www/data

# Set permissions
RUN chown -R www-data:www-data /var/www/html && \
    chmod -R 755 /var/www/html

# Initialize database
RUN su www-data -s /bin/sh -c "php /var/www/html/init_db.php"

EXPOSE 80

CMD ["apache2-foreground"]
