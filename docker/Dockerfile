FROM php:7.4-fpm-alpine

# Install essential build tools
RUN apk add --no-cache \
    git \
    yarn \
    autoconf \
    g++ \
    make \
    openssl-dev

# Install xdebug
RUN docker-php-source extract \
    && pecl install xdebug

WORKDIR /var/www/symfony
