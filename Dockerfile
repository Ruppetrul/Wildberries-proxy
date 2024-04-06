FROM php:8.2-apache

RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libzip-dev \
    zip \
    unzip \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd pdo_mysql zip

COPY ./ /var/www/html

RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap

RUN a2enmod rewrite

EXPOSE 80
