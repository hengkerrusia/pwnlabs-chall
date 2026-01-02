FROM php:8.2-apache

# Enable Apache modules
RUN a2enmod rewrite

# Place the flag in a realistic location
RUN echo "PwnLabs{upl04d_v4l1d4t10n_1s_cr1t1c4l}" > /var/www/flag.txt && \
    chmod 644 /var/www/flag.txt

# Copy and set up entrypoint script
COPY docker-entrypoint.sh /usr/local/bin/
RUN chmod +x /usr/local/bin/docker-entrypoint.sh

# Set working directory
WORKDIR /var/www/html

# Expose port 80
EXPOSE 80

# Use custom entrypoint
ENTRYPOINT ["/usr/local/bin/docker-entrypoint.sh"]
