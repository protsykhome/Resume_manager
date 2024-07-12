FROM php:8.3-fpm

RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libicu-dev \
    libpq-dev \
    libjpeg-dev \
    libpng-dev \
    libfreetype6-dev \
    libzip-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install \
    intl \
    pdo \
    pdo_mysql \
    gd \
    zip

# Установка Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Робочий каталог для проекту
WORKDIR /var/www/html

# Додавання користувача composer для запуску Composer
RUN useradd -ms /bin/bash composer

# Копіюємо файли проекту та встановлюємо залежності через Composer
COPY --chown=composer:composer . .

# Переключаємося на користувача composer і встановлюємо залежності
USER composer
RUN composer install

# Повертаємося до користувача root
USER root
