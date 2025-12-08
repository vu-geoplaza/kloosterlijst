FROM php:8.3-apache

RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli

RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"
COPY . /var/www/html/kloosterlijst

# Cannot start with unprivileged user on port 80
RUN sed -i 's/Listen 80/Listen 8080/' /etc/apache2/ports.conf