# Dockerfile
FROM php:7.4-fpm-alpine
# Install essential build tools
RUN apk add --no-cache \
    zip \
    unzip \
    php-zip

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
