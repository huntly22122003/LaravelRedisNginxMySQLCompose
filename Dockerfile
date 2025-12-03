FROM php:8.2-fpm
RUN docker-php-ext-install pdo pdo_mysql
# Cài composer và dockerize
RUN apt-get update && apt-get install -y curl unzip \
    && curl -sS https://getcomposer.org/installer | php \
    && mv composer.phar /usr/local/bin/composer \
    && curl -L https://github.com/jwilder/dockerize/releases/download/v0.6.1/dockerize-linux-amd64-v0.6.1.tar.gz \
       | tar -C /usr/local/bin -xz
       
RUN pecl install redis \
    && docker-php-ext-enable redis
