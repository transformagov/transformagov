FROM php:7.4-fpm
RUN apt update && apt install vim certbot python3-certbot-nginx telnet nginx sendmail libpq-dev libcurl4-openssl-dev git -y
RUN docker-php-ext-install pgsql curl mysqli
COPY docker/prod/transforma.conf /etc/nginx/conf.d/
COPY docker/etc/www.conf /etc/php/7.4/fpm/pool.d/
COPY docker/run.sh /tmp
RUN chmod +x /tmp/run.sh
COPY . /transformagov/
WORKDIR /transformagov/
RUN mkdir -p /transformagov/anexos/
RUN chown -R www-data:www-data /transformagov/anexos
# Use time zone configurated at .env
#RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone
