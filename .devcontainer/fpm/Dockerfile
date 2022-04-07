# From official php image.
FROM php:8.0-fpm-alpine
# Install postgres pdo driver.
RUN  docker-php-ext-install mysqli pdo pdo_mysql
# Install redis driver.
RUN mkdir -p /usr/src/php/ext/redis; \
    curl -fsSL --ipv4 https://github.com/phpredis/phpredis/archive/5.3.4.tar.gz | tar xvz -C "/usr/src/php/ext/redis" --strip 1; \
    docker-php-ext-install redis
