# This file is used to build the container that
# is connected to nginx. Do not rename or remove this file.
FROM php:8.2.0-fpm-alpine as development-cmd

RUN apk add --no-cache \
    bash \
    git \
    curl

RUN mkdir -p /var/www/cache
RUN chown -R www-data:www-data /var/www/cache

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
RUN chmod +x /usr/local/bin/composer

WORKDIR /src

COPY --chown=www-data:www-data . .

RUN composer install

CMD ["php-fpm"]


# This stage is used to watch for changes in the composer files
FROM php:8.2.0-alpine as development-all_up

RUN apk add --no-cache \
    bash \
    git \
    curl \
    entr

RUN mkdir -p /var/www/cache
RUN chown -R www-data:www-data /var/www/cache

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN chmod +x /usr/local/bin/composer

WORKDIR /src

COPY --chown=www-data:www-data . .

# Check composer.lock for `composer install`
# Check composer.json for included files
# Check vendor/composer for `composer dump-autoload`
CMD ["sh", "-c", "ls composer.* vendor/composer | entr -r timeout 5s composer install"]
