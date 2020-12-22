FROM debian:stable
RUN apt update && apt install php-fpm php-pgsql \
	php-mbstring php-curl php7.3-mysql -y
WORKDIR transforma-minas
#ENTRYPOINT service php7.3-fpm start && service nginx restart && tail -f /dev/null
#ENTRYPOINT php -S 127.0.0.1:80 
#ENTRYPOINT tail -f /dev/null
