FROM php:7.3-apache

ENV APACHE_DOCUMENT_ROOT /scraping-service/public

RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

RUN a2enmod rewrite

EXPOSE 80

WORKDIR /scraping-service

RUN apt-get update && apt-get install -y --no-install-recommends apt-utils

# Install dependencies
RUN apt-get update && apt-get install -y \
    libzip-dev \
    zlib1g-dev \
    chromium \
    libxml2-dev \
    libmcrypt-dev \
    git \
    zip \
    unzip \
    curl

# Install extensions
RUN docker-php-ext-install pdo_mysql mbstring zip bcmath json ctype xml tokenizer

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

COPY ./ /scraping-service
RUN composer install


CMD [ "/bin/bash", "apache2-foreground" ]
