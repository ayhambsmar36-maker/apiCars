FROM php:8.2-apache

# تثبيت المتطلبات
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libpq-dev \
    libzip-dev \
    && docker-php-ext-install pdo pdo_mysql pdo_pgsql zip

# تثبيت Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# نسخ ملفات المشروع
WORKDIR /var/www/html
COPY . .

# تثبيت الحزم عبر Composer
RUN composer install --no-dev --optimize-autoloader

# إعداد Apache
RUN chown -R www-data:www-data /var/www/html \
    && a2enmod rewrite

EXPOSE 80
CMD ["apache2-foreground"]

