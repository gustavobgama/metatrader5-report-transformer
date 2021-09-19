FROM php:8.1.0RC2-fpm-alpine3.14

LABEL maintainer="gustavobgama@gmail.com"

RUN docker-php-ext-install pdo_mysql

COPY --from=composer:2.1.3 /usr/bin/composer /usr/bin/composer

COPY composer.* /app/

WORKDIR /app

RUN composer install --no-autoloader --no-interaction

COPY . /app

RUN composer dump-autoload --no-scripts --optimize \
    && rm -rf /root/.composer

EXPOSE 8080