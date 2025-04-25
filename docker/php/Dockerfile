# Use an official PHP image with FPM. Choose the PHP version matching your project.
FROM php:8.2-fpm

# Set working directory
WORKDIR /var/www/html

# Install system dependencies required by Laravel and common extensions
# libzip-dev, zip, unzip: For Composer
# git: For Composer pulling private repos or specific commits
# libpng-dev, libjpeg-dev, libfreetype-dev: For GD extension
# libonig-dev, libxml2-dev: For mbstring and xml extensions
# mariadb-client: To connect to MariaDB from the PHP container (for artisan commands)
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    zip \
    libzip-dev \
    libpng-dev \
    libjpeg-dev \
    libfreetype-dev \
    libonig-dev \
    libxml2-dev \
    mariadb-client \
    && rm -rf /var/lib/apt/lists/*

# Install PHP extensions required by Laravel
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd \
    pdo_mysql \
    zip \
    mbstring \
    xml \
    bcmath

# Install Composer globally
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Optional: Install Node.js and NPM if you compile frontend assets
# RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash - \
#     && apt-get install -y nodejs

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Change user/group for permissions (match host user if needed, often www-data is fine)
# RUN groupadd -g 1000 laravel && useradd -u 1000 -ms /bin/bash -g laravel laravel
# USER laravel

# Expose port 9000 and start php-fpm server
EXPOSE 9000
CMD ["php-fpm"]

# Note: We don't copy the application code here.
# We will mount it using a volume in docker-compose.yml for development.
# For production, you would typically add:
# COPY . /var/www/html
# RUN composer install --optimize-autoloader --no-dev
# RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
