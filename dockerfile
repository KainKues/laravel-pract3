FROM php:8.3-apache

ENV APACHE_DOCUMENT_ROOT=/var/www/html/public

RUN apt-get update -y && apt-get install -y \
    ca-certificates \
    curl \
    libpq-dev \
    git \
    zip \
    unzip \
    libzip-dev \
    zlib1g-dev

RUN update-ca-certificates

RUN docker-php-ext-install pdo_pgsql pgsql
RUN docker-php-ext-install zip

COPY --from=composer:2 /usr/bin/composer /usr/local/bin/composer

RUN a2enmod rewrite

RUN sed -ri "s!/var/www/html!${APACHE_DOCUMENT_ROOT}!g" /etc/apache2/sites-available/000-default.conf

RUN printf "<Directory /var/www/html/public>\n\
    AllowOverride All\n\
    Require all granted\n\
</Directory>\n" > /etc/apache2/conf-available/laravel.conf \
    && a2enconf laravel

RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf

ENV COMPOSER_PROCESS_TIMEOUT=2000