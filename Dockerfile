FROM debian:stable
RUN apt update && apt install php-fpm php-pgsql \
	php-mbstring php-xml php-intl php-curl php7.4-mysql nginx sendmail npm git -y
COPY . /transformagov/
WORKDIR transformagov
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
RUN php -r "if (hash_file('sha384', 'composer-setup.php') === '906a84df04cea2aa72f40b5f787e49f22d4c2f19492ac310e8cba5b96ac8b64115ac402c8cd292b8a03482574915d1a8') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
RUN php composer-setup.php
RUN php -r "unlink('composer-setup.php');"
RUN mv composer.phar /usr/local/bin/composer
RUN php --ini
WORKDIR server
RUN npm i
RUN npx webpack
