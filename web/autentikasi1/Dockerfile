FROM php:8.2-fpm-alpine

# Install SQLite and PHP extensions
RUN apk add --no-cache sqlite sqlite-dev \
    && docker-php-ext-install pdo pdo_sqlite

# Create data directory with proper permissions
RUN mkdir -p /var/www/data \
    && chown -R www-data:www-data /var/www/data \
    && chmod -R 755 /var/www/data

# Copy entrypoint script
COPY docker-entrypoint.sh /usr/local/bin/
RUN chmod +x /usr/local/bin/docker-entrypoint.sh

# Set working directory
WORKDIR /var/www/html

# Expose PHP-FPM port
EXPOSE 9000

ENTRYPOINT ["docker-entrypoint.sh"]
CMD ["php-fpm"]
