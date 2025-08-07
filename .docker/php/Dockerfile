ARG PHP_VERSION=7.4

FROM php:${PHP_VERSION}-cli-alpine

RUN apk update && apk add --no-cache --virtual .build-deps \
    autoconf \
    build-base \
    libxml2-dev \
    oniguruma-dev \
    linux-headers \
    && docker-php-ext-install -j$(nproc) sockets \
    mbstring

RUN curl -sS https://getcomposer.org/installer | \
    php -- --2 --install-dir=/usr/local/bin --filename=composer
