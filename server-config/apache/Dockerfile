FROM php:8.0-apache
# активация возможности перезаписи в .htaccess
RUN a2enmod rewrite
RUN apt-get update && docker-php-ext-install mysqli
RUN apt-get -y install libaprutil1-dbd-mysql && a2enmod authn_dbd