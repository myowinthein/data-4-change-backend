FROM php:7.4-apache

RUN apt-get update && apt-get install -y \
        libzip-dev \
        libpng-dev \
        libxml2-dev \
        libonig-dev \
        zip \
        unzip \
        git \
        curl \
        default-mysql-client \
    && docker-php-ext-install \
        pdo \
        pdo_mysql \
        mbstring \
        xml \
        zip \
        bcmath \
        gd \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

RUN a2enmod rewrite

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Pre-install PHP dependencies at build time so runtime does not need network access.
# vendor/ is placed at /opt/vendor_bootstrap inside the image.
# The entrypoint copies it to /var/www/html/vendor/ on first boot,
# because the project volume mount replaces the working directory at runtime.
COPY composer.json composer.lock /tmp/composer_setup/
# classmap autoloader scans database/seeds and database/factories (declared in composer.json)
COPY database/ /tmp/composer_setup/database/
RUN COMPOSER_ALLOW_SUPERUSER=1 composer install \
        --working-dir=/tmp/composer_setup \
        --no-interaction \
        --no-scripts \
        --prefer-dist \
        --optimize-autoloader \
    && mv /tmp/composer_setup/vendor /opt/vendor_bootstrap \
    && rm -rf /tmp/composer_setup \
    # Patch Laravel 5.8.17 PackageManifest for Composer 2 compatibility.
    # v5.8.17 reads installed.json directly; Composer 2 wraps packages under a 'packages' key.
    # Fix backported from Laravel 5.8.36. No API or behaviour change.
    && sed -i \
        's/\$packages = json_decode(\$this->files->get(\$path), true);/\$installed = json_decode(\$this->files->get(\$path), true); \$packages = \$installed["packages"] ?? \$installed;/' \
        /opt/vendor_bootstrap/laravel/framework/src/Illuminate/Foundation/PackageManifest.php

COPY docker/apache/000-default.conf /etc/apache2/sites-available/000-default.conf
COPY docker/php/php.ini /usr/local/etc/php/conf.d/custom.ini
COPY docker/entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

WORKDIR /var/www/html

ENTRYPOINT ["entrypoint.sh"]
