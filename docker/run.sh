#!/bin/sh
# php logs folder
mkdir -p application/logs
chown www-data:www-data application/logs

# php service
mkdir /run/php/
php-fpm -y /etc/php/7.4/fpm/pool.d/www.conf -D

#keep the container running
nginx -g 'daemon off;'
