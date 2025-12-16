FROM blabster-backend_php-fpm:0.0.1 AS build

RUN git clone https://github.com/s-drozdov/blabster-backend.git ./
COPY --from=composer/composer:latest-bin /composer /usr/local/bin/composer
RUN COMPOSER_ALLOW_SUPERUSER=1 composer install --no-scripts --no-interaction

FROM blabster-backend_php-fpm:0.0.1

COPY --from=build --chown=www-data:www-data /var/www/html /var/www/html 
COPY --chown=www-data:www-data . .

USER www-data

EXPOSE 9000
