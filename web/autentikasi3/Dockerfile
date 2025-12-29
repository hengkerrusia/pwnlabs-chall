FROM php:8.2-fpm-alpine

RUN apk add --no-cache nginx

COPY nginx/nginx.conf /etc/nginx/nginx.conf
COPY www /var/www/html

RUN chown -R www-data:www-data /var/www/html && \
    chmod -R 755 /var/www/html

COPY entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh

EXPOSE 80

ENTRYPOINT ["/entrypoint.sh"]
