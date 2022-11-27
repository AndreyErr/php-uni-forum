FROM php:8.0-apache
# Активация возможности перезаписи в .htaccess
RUN a2enmod rewrite
# Активация использование mysql
RUN apt-get update && docker-php-ext-install mysqli

RUN pecl install redis
RUN docker-php-ext-enable redis

RUN pecl install xdebug
RUN docker-php-ext-enable xdebug

RUN service apache2 restart

