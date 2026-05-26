FROM php:8.5-fpm

# nginx + supervisor + app build deps
# php:8.5-fpm already bundles curl, mbstring, SimpleXML, PDO, pdo_sqlite, sqlite3 — only add zip + gd + pgsql + redis.
RUN apt-get update && apt-get install -y --no-install-recommends \
  $PHPIZE_DEPS \
  git \
  nginx \
  supervisor \
  unzip \
  libzip-dev \
  libpng-dev \
  libjpeg-dev \
  libwebp-dev \
  libfreetype6-dev \
  libpq-dev \
  && docker-php-ext-configure gd --with-freetype --with-jpeg --with-webp \
  && docker-php-ext-install \
  zip \
  gd \
  pdo_pgsql \
  pgsql \
  && pecl install redis \
  && docker-php-ext-enable redis \
  && apt-get purge -y --auto-remove -o APT::AutoRemove::RecommendsImportant=false $PHPIZE_DEPS \
  && rm -rf /var/lib/apt/lists/*

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /app

# Copy October app (overridden by bind mount in compose for local dev)
COPY october/ .

# Install dependencies
RUN composer install --no-dev --optimize-autoloader --no-interaction

# nginx + php-fpm integration
RUN rm -f /etc/nginx/sites-enabled/default
COPY runtime/nginx/default.conf /etc/nginx/sites-enabled/laravel.conf
COPY runtime/php-fpm/zz-ecs.conf /usr/local/etc/php-fpm.d/zz-ecs.conf
COPY runtime/supervisor/supervisord.conf /etc/supervisor/supervisord.conf

RUN mkdir -p /var/log/supervisor \
  && chown -R www-data:www-data database storage bootstrap/cache \
  && chmod -R ug+rwx database storage bootstrap/cache || true

EXPOSE 80

CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/supervisord.conf"]
