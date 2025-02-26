FROM php:8.2-apache
 
RUN apt-get update && apt-get install -y libssl-dev sendmail libpng-dev zlib1g-dev libzip-dev nano
 
RUN docker-php-ext-configure ftp --with-openssl-dir=/usr && docker-php-ext-install ftp

RUN docker-php-ext-install zip
RUN docker-php-ext-install gd
RUN docker-php-ext-install mysqli
