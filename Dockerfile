FROM debian:stable
RUN apt update && apt install php-fpm php-pgsql \
	php-mbstring php-curl php7.3-mysql nginx -y
COPY transforma.conf /etc/nginx/conf.d/
COPY run.sh /tmp
RUN chmod +x /tmp/run.sh
COPY . /transforma-minas/
WORKDIR transforma-minas
