#!/bin/sh
# env
echo print env
env

# php logs folder
mkdir -p application/logs
chown www-data:www-data application/logs

# php service
/etc/init.d/php7.4-fpm start

#keep the container running
nginx -g 'daemon off;'
