FROM php:8.2-apache

RUN apt-get update -y && apt-get install -y sendmail libpng-dev zlib1g-dev libzip-dev nano

RUN docker-php-ext-install zip
RUN docker-php-ext-install gd
RUN docker-php-ext-install mysqli
