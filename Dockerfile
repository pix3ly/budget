ARG COMPOSER_IMAGE_VERSION=1.10
ARG NODE_IMAGE_VERSION=14.4
ARG PHP_IMAGE_VERSION=7.2-fpm-buster

FROM composer:${COMPOSER_IMAGE_VERSION} as composer

FROM node:${NODE_IMAGE_VERSION} as assets

WORKDIR /build

COPY yarn.lock package.json webpack.mix.js ./

RUN yarn install

COPY ./resources ./resources

RUN yarn run production

FROM php:${PHP_IMAGE_VERSION}

ARG NGINX_PACKAGE_VERSION
ARG SUPERVISOR_PACKAGE_VERSION
ARG CRON_PACKAGE_VERSION

# Install nginx as webserver, and some packages needed for php extensions
RUN apt-get update && apt-get install -y \
    nginx-light \
    supervisor \
    cron \
    libzip-dev \
    unzip \
 && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql \
 && docker-php-ext-install zip \
 && docker-php-ext-install calendar

COPY nginx.conf /etc/nginx/sites-enabled/default
COPY cron.conf /etc/cron.d/budget
COPY supervisord.conf /etc/supervisor/conf.d/budget.conf
COPY docker_boot.sh /usr/bin/docker-entrypoint
ENTRYPOINT ["docker-entrypoint"]

COPY --from=composer /usr/bin/composer /usr/bin/composer

WORKDIR /usr/share/nginx/budget

COPY composer.json composer.lock ./
RUN composer install --no-dev --no-scripts --no-autoloader

COPY --chown=www-data . ./
COPY --chown=www-data --from=assets /build/public/ ./public/

RUN composer dumpautoload -oa

EXPOSE 80

CMD ["/usr/bin/supervisord", "-l", "/dev/null", "-n", "-c", "/etc/supervisor/supervisord.conf"]
