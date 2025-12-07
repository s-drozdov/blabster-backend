FROM harbor.dev.tails.fun/tails-fun/base_php-fpm:0.0.2 AS build

RUN apt-get update && apt-get install -y --no-install-recommends \
    libmemcached-dev \
    zlib1g-dev \
    pkg-config \
    && pecl install memcached \
    && docker-php-ext-enable memcached

COPY ../../../composer.* ./
RUN curl -sS https://getcomposer.org/installer | php && \
    mv composer.phar /usr/local/bin/composer
RUN COMPOSER_ALLOW_SUPERUSER=1 composer install --no-scripts --no-interaction

FROM harbor.dev.tails.fun/tails-fun/base_php-fpm:0.0.2

COPY --from=build --chown=www-data:www-data /var/www/html /var/www/html 
COPY --chown=www-data:www-data . .

USER www-data

EXPOSE 9000
