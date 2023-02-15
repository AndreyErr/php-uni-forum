FROM php:8.0-apache

# Активация возможности перезаписи в .htaccess
RUN a2enmod rewrite

# Активация использование mysql
RUN apt-get update && docker-php-ext-install mysqli

# Локальный почтовый сервер для тестирования email
RUN apt-get install --no-install-recommends --assume-yes --quiet ca-certificates curl git &&\
    rm -rf /var/lib/apt/lists/*
RUN curl -Lsf 'https://storage.googleapis.com/golang/go1.8.3.linux-amd64.tar.gz' | tar -C '/usr/local' -xvzf -
ENV PATH /usr/local/go/bin:$PATH
RUN go get github.com/mailhog/mhsendmail
RUN cp /root/go/bin/mhsendmail /usr/bin/mhsendmail

# Дебагер //////////ТОЛЬКО ДЛЯ РАЗРАБОТКИ////////////////////
RUN pecl install xdebug
RUN docker-php-ext-enable xdebug

#RUN service apache2 restart