FROM php:8.1-cli

RUN set -xe \
    && apt-get update \
    && apt-get -y install git zip \
    && docker-php-ext-install -j$(nproc) intl bcmath gmp

COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer
COPY . /app
WORKDIR /app
