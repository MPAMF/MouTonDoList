# TODO import composer & add SASS
FROM php:8.1-fpm

# Update system
RUN apt-get update && apt-get install --yes --fix-missing git libzip-dev zip nodejs npm

# Install sass
RUN npm install --global sass

# Install composer from the official image
COPY --from=composer /usr/bin/composer /usr/bin/composer

# Run composer install to install the dependencies
# RUN composer install --optimize-autoloader --no-interaction --no-progress
# RUN composer make-static

ENV TZ=Europe/Paris
ENV PHP_IDE_CONFIG="serverName=MouTonDoList"

RUN pecl install xdebug && \
 docker-php-ext-enable xdebug && \
 docker-php-ext-install pdo pdo_mysql bcmath

RUN echo 'xdebug.mode=develop,debug' >> /usr/local/etc/php/php.ini
RUN echo 'xdebug.client_host=host.docker.internal' >> /usr/local/etc/php/php.ini
RUN echo 'xdebug.start_with_request=yes' >> /usr/local/etc/php/php.ini