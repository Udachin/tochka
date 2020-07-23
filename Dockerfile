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

# Add user for laravel application
RUN groupadd -g 1000 www \
 && useradd -u 1000 -ms /bin/bash -g www www

# Copy existing application directory contents
COPY . /var/www

# Final
USER root
RUN chown -R www:www /var/www
RUN chmod -R ug+rwx /var/www/storage /var/www/bootstrap/cache
EXPOSE 9000
CMD ["php-fpm"]
