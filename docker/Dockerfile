FROM php:8.0-apache
WORKDIR /var/www/html

RUN apt-get update && apt-get install -y \
    && apt-get install python3 -y \
    && docker-php-ext-install mysqli && docker-php-ext-enable mysqli \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd \
    && docker-php-ext-install pdo_mysql \
    && a2enmod rewrite && service apache2 restart

COPY --from=composer /usr/bin/composer /usr/bin/composer