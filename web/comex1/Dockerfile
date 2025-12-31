FROM php:8.2-apache

# Install ping utility
RUN apt-get update && \
    apt-get install -y iputils-ping && \
    rm -rf /var/lib/apt/lists/*

# Add flag to /etc/passwd as a comment
RUN echo "# PwnLabs{c0mm4nd_1nj3ct10n_1s_d4ng3r0us_4f89b2c1}" >> /etc/passwd

# Copy application files
COPY src/ /var/www/html/

# Set proper permissions
RUN chown -R www-data:www-data /var/www/html && \
    chmod -R 755 /var/www/html

# Enable Apache modules
RUN a2enmod rewrite

# Expose port 80
EXPOSE 80

# Start Apache
CMD ["apache2-foreground"]
