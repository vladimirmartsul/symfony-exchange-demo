FROM php:8.1-cli-alpine

RUN set -eux ; \
    apk add --no-cache --quiet icu-dev; \
    docker-php-ext-install -j$(nproc) bcmath intl; \
    docker-php-ext-enable opcache; \
    curl -sS --compressed https://getcomposer.org/installer | php -- --install-dir=/usr/bin --filename=composer --quiet

COPY docker-php-entrypoint /usr/local/bin/

ENV COMPOSER_HOME=/tmp

WORKDIR /app

CMD (( [ -d vendor ] || (( composer install --no-ansi --no-dev --no-interaction --no-progress && php bin/console doctrine:database:create && php bin/console doctrine:migrations:migrate --no-interaction )) )) && php bin/console currency:update
