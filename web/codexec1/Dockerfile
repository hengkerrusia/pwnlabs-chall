FROM php:7.4-apache

# Setup flag
RUN echo "PwnLabs{3v4l_1s_3v1l_n3v3r_trust_us3r_1nput}" >> /etc/passwd

# Copy application source
COPY src/ /var/www/html/

# Set correct permissions
RUN chown -R www-data:www-data /var/www/html/ \
    && chmod -R 755 /var/www/html/
