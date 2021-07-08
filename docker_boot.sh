#!/usr/bin/env bash

set -e

DB_HOST="${DB_HOST:?environment variable is missing}"
DB_PORT="${DB_PORT:-3306}"

./wait-for-it.sh "${DB_HOST}:${DB_PORT}" -- php artisan migrate --force

# php artisan optimize

php artisan storage:link

exec $@