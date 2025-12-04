FROM harbor.dev.tails.fun/tails-fun/base_php-fpm:0.0.2 AS build

ARG PUID
ARG PGID
ARG SSH_KEY

RUN groupmod -o -g $PGID www-data && \
    usermod -o -u $PUID -g www-data www-data && \
    usermod -md /home/www-data www-data

RUN mkdir -p /home/www-data/.composer \
    && mkdir -p /home/www-data/.ssh \
    && chown -R www-data:www-data /home/www-data

# SSH
RUN touch /home/www-data/.ssh/id_rsa
RUN echo "$SSH_KEY" | tr -d '\r' > /home/www-data/.ssh/id_rsa
RUN if [ ! -z "$SSH_KEY" ]; then \
  touch /home/www-data/.ssh/known_hosts \
;fi
RUN chown -R www-data:www-data /home/www-data/.ssh \
    && chmod 600 /home/www-data/.ssh/id_rsa

# Composer
COPY --from=composer/composer:latest-bin /composer /usr/local/bin/composer

# изменение порта прослушивания php-fpm
# иначе 404 через раз если два php-fpm сервиса в одном network
# см. (тут)[https://github.com/docker/compose/issues/7366]
ARG FPM_PORT
RUN sed -i "s/9000/$FPM_PORT/" /usr/local/etc/php-fpm.d/zz-docker.conf

USER www-data

ARG APP_NAME
WORKDIR /var/www/$APP_NAME

