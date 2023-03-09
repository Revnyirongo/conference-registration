FROM php:7.3-fpm-alpine

RUN docker-php-ext-install pdo pdo_mysql
RUN docker-php-ext-install mysqli && docker-php-ext-enable mysqli

RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" && \
    php composer-setup.php --install-dir=/usr/local/bin --filename=composer && \
    rm composer-setup.php

WORKDIR /var/www/html/

COPY . /var/www/html/

RUN composer install --no-scripts --no-autoloader && \
    composer dump-autoload --optimize && \
    chown -R www-data:www-data /var/www/html

EXPOSE 8082

ENV COMPOSER_ALLOW_SUPERUSER=1

RUN apk update && \
    apk upgrade && \
    apk add bash && \
    apk add --virtual .build-deps && \
    apk del .build-deps

CMD ["php-fpm"]
