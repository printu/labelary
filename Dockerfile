FROM php:8.2-cli

RUN mkdir -p /var/www/site

RUN pecl install xdebug \
    && docker-php-ext-enable xdebug

WORKDIR /var/www/site