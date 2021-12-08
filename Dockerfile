FROM debian:stable
RUN apt update && apt install php-fpm php-pgsql \
	php-mbstring php-curl php7.4-mysql nginx sendmail -y
COPY transforma.conf /etc/nginx/conf.d/
COPY  www.conf /etc/php/7.4/fpm/pool.d/
COPY run.sh /tmp
RUN chmod +x /tmp/run.sh
COPY . /transformagov/
WORKDIR transformagov

# Use time zone configurated at .env
RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone
