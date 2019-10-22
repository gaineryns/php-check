# php-fpm
FROM php:7.3-fpm-alpine3.10

# install the PHP extensions we need
RUN apk upgrade --update && apk add --no-cache \
  autoconf file g++ gcc binutils isl libatomic libc-dev musl-dev make re2c libstdc++ libgcc libzip-dev mpc1 mpfr3 gmp libgomp \
  coreutils \
  freetype-dev \
  libjpeg-turbo-dev \
  libltdl \
  libmcrypt-dev \
  libpng-dev \
  postgresql-dev \
  curl \
  libxml2-dev \
  nginx \
&& docker-php-ext-configure gd --with-png-dir=/usr --with-jpeg-dir=/usr \
&& docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
&& docker-php-ext-install zip pdo pdo_pgsql pgsql gd mysqli opcache soap \
&& pecl install pcov \
&& docker-php-ext-enable pcov \
&& rm -rf /var/cache/apk/* /tmp/* /var/tmp/* 


WORKDIR /var/www/html

# Bundle app source
COPY . .

# Nginx
RUN rm /etc/nginx/conf.d/default.conf
RUN mkdir /var/tmp/nginx 
COPY ./docker/prod/nginx/default-symfony.conf /etc/nginx/conf.d/
COPY ./docker/prod/nginx/nginx.conf /etc/nginx/nginx.conf
COPY public /var/www/html/public

RUN chown -R www-data:www-data var/ public/

COPY "./docker/prod/php/memory-limit-php.ini" "/usr/local/etc/php/conf.d/memory-limit-php.ini"

EXPOSE 9000
EXPOSE 80

CMD ["/bin/sh", "-c", "php-fpm -F & nginx -g 'daemon off;'"]