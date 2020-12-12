FROM php:7.4-apache

RUN apt-get update
RUN apt-get install zip unzip
RUN apt-get install -y libfreetype6-dev zlib1g-dev libpng-dev libjpeg62-turbo-dev
RUN docker-php-ext-install pdo_mysql mysqli
RUN docker-php-ext-install exif
RUN docker-php-ext-configure gd --with-freetype --with-jpeg
RUN docker-php-ext-install gd

# allow url rewrites so index.php is not required in urls
RUN a2enmod rewrite

# overwrite apache conf to change document root
COPY /docker/apache /etc/apache2/sites-enabled

# Copy the application
COPY . /var/www/html

EXPOSE 80 443