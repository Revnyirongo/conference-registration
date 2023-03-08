FROM php:7.3-fpm-alpine

RUN docker-php-ext-install pdo pdo_mysql
RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli
RUN php -r "readfile('http://getcomposer.org/installer');" | php -- --install-dir=/usr/bin/ --filename=composer && \
    cd /var/www/html && \
    composer require phpmailer/phpmailer && \
    chown -R www-data:www-data /var/www/html/vendor
RUN apk update
RUN apk upgrade
RUN apk add bash
RUN alias composer='php /usr/bin/composer'

COPY . /var/www/html/
WORKDIR /var/www/html/

EXPOSE 8081

RUN composer update --no-scripts 

ENV COMPOSER_ALLOW_SUPERUSER=1

RUN composer dump-autoload

RUN composer install
