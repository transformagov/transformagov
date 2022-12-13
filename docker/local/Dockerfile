FROM php:7.4-fpm
RUN apt update && apt install sendmail libpq-dev libcurl4-openssl-dev git -y
RUN docker-php-ext-install pgsql curl mysqli
COPY docker/etc/www.conf /etc/php/7.4/fpm/pool.d/
WORKDIR /transformagov/
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin --filename=composer
RUN mkdir -p /transformagov/anexos/
RUN chown -R www-data:www-data /transformagov/anexos
# Use time zone configurated at .env
#RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone
