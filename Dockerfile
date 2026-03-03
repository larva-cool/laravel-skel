FROM docker.cnb.cool/larva-cool/php:8.4-alpine

ARG ENV=prod

WORKDIR /app

COPY . /app

RUN mv .env.${ENV} /app/.env && \
    composer install --prefer-dist --no-progress --optimize-autoloader

VOLUME [ "/app/runtime/logs" ]

EXPOSE 8787/tcp

ENTRYPOINT ["php", "artisan", "octane:start"]
