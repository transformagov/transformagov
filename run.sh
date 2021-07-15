#!/bin/sh
# php logs folder
mkdir -p application/logs
chown www-data:www-data application/logs

# php service
# service php7.3-fpm start

# https://serverfault.com/questions/813368/configure-php-fpm-to-access-environment-variables-in-docker
#/etc/init.d/php7.3-fpm start && nginx -g 'daemon off;'
/etc/init.d/php7.3-fpm start

# http server
service nginx start 

#keep the container running
tail -f /dev/null
