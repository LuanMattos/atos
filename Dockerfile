FROM php:7.3.12-apache
RUN buildDeps=" \
        libicu-dev \
        zlib1g-dev \
        libsqlite3-dev \
        libpq-dev \
    " \
    && apt-get update \
    && apt-get install -y --no-install-recommends \
        $buildDeps \
        php-pgsql \


        bunda