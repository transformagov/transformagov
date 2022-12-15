from nginx:latest
RUN apt update && apt install vim certbot python3-certbot-nginx telnet nginx sendmail libpq-dev libcurl4-openssl-dev git -y
COPY docker/local/reverse_proxy/default.conf /etc/nginx/conf.d/default.conf
