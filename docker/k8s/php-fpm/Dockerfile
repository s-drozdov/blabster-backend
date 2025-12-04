FROM harbor.dev.tails.fun/tails-fun/base_php-fpm:0.0.2 AS build

ARG SSH_KEY

RUN mkdir -p /root/.ssh
RUN echo "$SSH_KEY" | tr -d '\r' > /root/.ssh/id_rsa && \
    chmod 600 /root/.ssh/id_rsa && \
    ssh-keyscan github.com >> /root/.ssh/known_hosts

COPY ../../../composer.* ./
RUN curl -sS https://getcomposer.org/installer | php && \
    mv composer.phar /usr/local/bin/composer
RUN COMPOSER_ALLOW_SUPERUSER=1 composer install --no-scripts --no-interaction

FROM harbor.dev.tails.fun/tails-fun/base_php-fpm:0.0.2

COPY --from=build --chown=www-data:www-data /var/www/html /var/www/html 
COPY --chown=www-data:www-data . .

USER www-data

EXPOSE 9000
