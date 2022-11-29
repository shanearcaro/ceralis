FROM php:8.0-apache
WORKDIR /var/www/html

RUN apt-get update && apt-get install
RUN apt-get install python3 -y
RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli
RUN docker-php-ext-install pdo_mysql
RUN a2enmod rewrite && service apache2 restart

USER root

COPY --from=composer /usr/bin/composer /usr/bin/composer