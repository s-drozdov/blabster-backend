FROM php:8.4-fpm AS blabster-backend_php-fpm

ARG TZ=Etc/UTC
ARG PUID=1000
ARG PGID=1000

RUN apt-get update && apt-get install -y --no-install-recommends \
    git \
    unzip \
    wget \
    sqlite3 \
    openssh-client \
    libldap2-dev \
    libzip-dev \
    libssh2-1-dev \
    libpng-dev \
    libssh2-1 \
    libicu-dev \
    libsqlite3-dev \
    libmemcached-dev \
    zlib1g-dev \
    pkg-config \
    && ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone \
    && ln -s /usr/local/bin/php /usr/bin/php \
    && docker-php-ext-configure intl \
    && docker-php-ext-install intl gd pcntl zip pdo_sqlite \
    && pecl install pcov memcached \
    && docker-php-ext-enable pcov memcached

RUN groupmod -o -g $PGID www-data \
    && usermod -o -u $PUID -g www-data www-data \
    && usermod -md /home/www-data www-data \
    && mkdir -p /home/www-data/.composer \
    && mkdir -p /home/www-data/.ssh \
    && chown -R www-data:www-data /home/www-data
