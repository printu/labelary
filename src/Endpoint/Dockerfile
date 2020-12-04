FROM php:8.0-cli

RUN mkdir -p /var/www/site

RUN pecl install xdebug-3.0.0 \
    && docker-php-ext-enable xdebug

WORKDIR /var/www/site