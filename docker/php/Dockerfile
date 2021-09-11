FROM php:8.0-fpm

ENV COMPOSER_ALLOW_SUPERUSER=1

COPY bash.bashrc /etc/bash.bashrc
COPY overrides.ini /usr/local/etc/php/conf.d/99-overrides.ini
COPY xdebug.ini /usr/local/etc/php/conf.d/xdebug.ini

RUN apt-get update && apt-get install -y \
    curl \
    wget \
    git \
    zip \
    unzip \
    libicu-dev \
    libzip-dev \
    zlib1g-dev \
    libmagickwand-dev --no-install-recommends \
    && pecl install xdebug \
    && pecl install imagick \
    && docker-php-ext-enable xdebug \
    && docker-php-ext-enable imagick \
    && docker-php-ext-install intl pdo pdo_mysql zip \
    && usermod -u 1000 www-data \
    && groupmod -g 1000 www-data

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
