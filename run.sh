#!/bin/sh
# php logs folder
mkdir -p application/logs
chown www-data:www-data application/logs

# https://serverfault.com/questions/813368/configure-php-fpm-to-access-environment-variables-in-docker
sed -i "s#;clear_env = no#clear_env = no#" /etc/php/7.2/fpm/pool.d/www.conf

# php service
/etc/init.d/php7.3-fpm start

#keep the container running
nginx -g 'daemon off;'
