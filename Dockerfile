FROM php:7.3-fpm-alpine

RUN apk --no-cache add openssl-dev ca-certificates \
    && docker-php-ext-install pdo pdo_mysql \
    && docker-php-ext-install mysqli \
    && docker-php-ext-enable mysqli

RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" && \
    php composer-setup.php --install-dir=/usr/local/bin --filename=composer && \
    rm composer-setup.php

WORKDIR /var/www/html/

COPY . /var/www/html/

RUN composer install --no-scripts --no-autoloader && \
    composer dump-autoload --optimize && \
    chown -R www-data:www-data /var/www/html

RUN apk update && \
    apk upgrade && \
    apk add bash && \
    apk add --virtual .build-deps && \
    apk del .build-deps

EXPOSE 8082

ENV COMPOSER_ALLOW_SUPERUSER=1

CMD ["php-fpm"]
