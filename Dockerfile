FROM php:7.3-fpm-alpine

RUN docker-php-ext-install pdo pdo_mysql
RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli

RUN php -r "readfile('http://getcomposer.org/installer');" | php -- --install-dir=/usr/bin/ --filename=composer
RUN apk update
RUN apk upgrade
RUN apk add bash
RUN alias composer='php /usr/bin/composer'

COPY . /var/www/html/
WORKDIR /var/www/html/

RUN composer update --no-scripts 

RUN composer dump-autoload

RUN composer install
