FROM php:7.3-fpm

# Install dependencies
RUN apt-get update \
 && apt-get install -y \
      build-essential \
      libzip-dev \
      libpng-dev \
      libjpeg62-turbo-dev \
      libwebp-dev libjpeg62-turbo-dev libpng-dev libxpm-dev \
      libfreetype6 \
      libfreetype6-dev \
      locales \
      zip \
      jpegoptim optipng pngquant gifsicle \
      vim \
      unzip \
      git \
      curl \
 && apt-get clean \
 && rm -rf /var/lib/apt/lists/*

# Install extensions
RUN docker-php-ext-install pdo_mysql mbstring zip exif pcntl \
 && pecl install redis && docker-php-ext-enable redis

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Copy existing application directory contents
COPY --chown=www-data:www-data . /var/www

RUN chown -R www-data:www-data /var/www
RUN chmod -R ug+rwx /var/www/storage /var/www/bootstrap/cache
EXPOSE 9000

USER www-data
CMD ["php-fpm"]
