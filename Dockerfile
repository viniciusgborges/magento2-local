FROM php:8.2-apache

# Install system dependencies and PHP extensions required by Magento
RUN apt-get update && \
    apt-get install -y libfreetype6-dev libjpeg62-turbo-dev libpng-dev libzip-dev unzip git && \
    docker-php-ext-configure gd --with-freetype --with-jpeg && \
    docker-php-ext-install pdo_mysql gd intl bcmath opcache zip && \
    rm -rf /var/lib/apt/lists/*

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Copy source after composer to leverage docker cache in real setup
COPY src/ /var/www/html

# Set recommended PHP settings for Magento
RUN { \
    echo 'memory_limit=2G'; \
    echo 'max_execution_time=1800'; \
    echo 'zlib.output_compression=On'; \
} > /usr/local/etc/php/conf.d/magento.ini

EXPOSE 80
CMD ["apache2-foreground"]
