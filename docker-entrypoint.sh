#!/bin/sh

# Run Laravel key:generate if APP_KEY is not set
if [ -z "$APP_KEY" ]; then
    php artisan key:generate
    php artisan migrate:fresh --seed
fi

# Run supervisor
/usr/bin/supervisord -c /etc/supervisor/conf.d/supervisord.conf
