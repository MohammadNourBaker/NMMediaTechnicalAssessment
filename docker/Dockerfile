FROM php:8.0.0-fpm


WORKDIR /var/www/html

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN docker-php-ext-install mysqli
RUN apt-get update && \
    apt-get install -y \
        sendmail \
        zlib1g-dev \
        libonig-dev \
        libzip-dev \
        libpng-dev \
        libjpeg-dev \
        libfreetype6-dev \
        ssh \
        rsync \
        libsodium-dev  \
        pkg-config \
        zip unzip \
        libicu-dev \
        libxml2-dev \
        libmagickwand-dev  \
        libmagickcore-dev


RUN apt install -y git

RUN pecl install xdebug && docker-php-ext-enable xdebug

RUN docker-php-ext-install dom

RUN docker-php-ext-install exif

RUN docker-php-ext-install intl

RUN docker-php-ext-install mbstring

RUN pecl install imagick && docker-php-ext-enable imagick

RUN docker-php-ext-install simplexml

RUN docker-php-ext-install zip

RUN docker-php-ext-configure gd --with-freetype --with-jpeg

RUN docker-php-ext-install gd
RUN echo zend_extension = "xdebug.so"
RUN echo 'xdebug.mode=debug' >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
RUN echo 'xdebug.start_with_request=yes' >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
RUN echo 'xdebug.client_host=host.docker.internal' >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
RUN echo 'xdebug.client_port=9000' >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

