#!/bin/bash

chown -R www-data:www-data /var/www/storage

if [ ! -z $BUDGET_SETUP ]; then
  composer install
  cp .env.docker .env
  php artisan key:generate
  php artisan storage:link

  yarn install
  yarn production

  php artisan migrate --force
fi

supervisord -n -c supervisord.conf
