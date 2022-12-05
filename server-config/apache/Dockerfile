FROM php:8.0-apache

# Активация возможности перезаписи в .htaccess
RUN a2enmod rewrite

# Активация использование mysql
RUN apt-get update && docker-php-ext-install mysqli

