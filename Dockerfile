FROM php:8.2-fpm

RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libzip-dev \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    curl \
    && docker-php-ext-install pdo pdo_mysql mbstring zip exif pcntl bcmath

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /var/www/html

COPY . /var/www/html

RUN chmod +x /var/www/html/docker-entrypoint.sh

# Force php-fpm pool to listen on all interfaces so Nginx can reach it
RUN sed -i 's|listen = 127.0.0.1:9000|listen = 0.0.0.0:9000|g' /usr/local/etc/php-fpm.d/www.conf \
    && echo "[www]" > /usr/local/etc/php-fpm.d/zzz-override.conf \
    && echo "listen = 0.0.0.0:9000" >> /usr/local/etc/php-fpm.d/zzz-override.conf \
    && echo "clear_env = no" >> /usr/local/etc/php-fpm.d/zzz-override.conf

ENTRYPOINT ["sh", "/var/www/html/docker-entrypoint.sh"]
