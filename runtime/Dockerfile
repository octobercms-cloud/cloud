FROM php:8.5-fpm

# nginx + supervisor + app build deps
# php:8.5-fpm already bundles curl, mbstring, SimpleXML, PDO, pdo_sqlite, sqlite3 — only add zip + gd.
RUN apt-get update && apt-get install -y --no-install-recommends \
  git \
  nginx \
  supervisor \
  unzip \
  libzip-dev \
  libpng-dev \
  libjpeg-dev \
  libwebp-dev \
  libfreetype6-dev \
  && docker-php-ext-configure gd --with-freetype --with-jpeg --with-webp \
  && docker-php-ext-install \
  zip \
  gd \
  && rm -rf /var/lib/apt/lists/*

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /app

# Copy October app
COPY october-app/ .

# Install dependencies
RUN composer install --no-dev --optimize-autoloader --no-interaction

# nginx + php-fpm integration
RUN rm -f /etc/nginx/sites-enabled/default
COPY nginx/default.conf /etc/nginx/sites-enabled/laravel.conf
COPY php-fpm/zz-ecs.conf /usr/local/etc/php-fpm.d/zz-ecs.conf
COPY supervisor/supervisord.conf /etc/supervisor/supervisord.conf

RUN mkdir -p /var/log/supervisor \
  && chown -R www-data:www-data database storage bootstrap/cache \
  && chmod -R ug+rwx database storage bootstrap/cache || true

EXPOSE 80

CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/supervisord.conf"]
