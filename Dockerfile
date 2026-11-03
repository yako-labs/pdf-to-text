FROM php:8.4-cli-alpine

COPY --from=composer:2 /usr/bin/composer /usr/local/bin/composer

WORKDIR /app
