FROM php:8.5-cli AS build

WORKDIR /srv

RUN apt-get update \
    && apt-get install -y --no-install-recommends git vim unzip libzip-dev nodejs npm \
    && docker-php-ext-install zip pcntl \
    && pecl install redis \
    && docker-php-ext-enable redis \
    && rm -rf /var/lib/apt/lists/*

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
RUN composer create-project --no-interaction --no-progress statamic/statamic app

COPY . /srv/package
WORKDIR /srv/app
COPY devenv/users/ /srv/app/users/
RUN composer config minimum-stability dev \
    && composer config prefer-stable true \
    && composer config repositories.statamic-healthchecks path /srv/package \
    && composer require --no-interaction --no-progress govigilant/statamic-healthchecks:dev-main \
    && php artisan key:generate \
    && php please stache:warm \
    && npm install \
    && npm run build

FROM php:8.5-cli
WORKDIR /var/www/html
RUN mkdir /var/www/html/users
COPY devenv/users/ /var/www/html/users/

RUN apt-get update \
    && apt-get install -y --no-install-recommends git vim unzip libzip-dev redis-server supervisor nodejs npm \
    && docker-php-ext-install zip pcntl \
    && pecl install redis \
    && docker-php-ext-enable redis \
    && rm -rf /var/lib/apt/lists/*

COPY --from=build /srv/app /var/www/html
COPY devenv/supervisord.conf /etc/supervisor/conf.d/statamic-healthchecks.conf

RUN mkdir -p /var/log/supervisor

EXPOSE 8000
CMD ["supervisord", "-n"]
