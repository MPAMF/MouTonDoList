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

RUN pecl install xdebug-3.1.5 && \
 docker-php-ext-enable xdebug && \
 docker-php-ext-install pdo pdo_mysql bcmath
