FROM php:8.4-fpm

ARG UID=1000
ARG GID=1000

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    zip \
    unzip \
    default-mysql-client \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip

# Install Node.js 20
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Create system user
RUN groupadd -g ${GID} appgroup && \
    useradd -u ${UID} -g appgroup -m appuser

WORKDIR /var/www/html

# Copy dependency files first for caching
COPY --chown=appuser:appgroup composer.json composer.lock ./
COPY --chown=appuser:appgroup package.json package-lock.json ./

# Install dependencies
RUN composer install --no-interaction --no-scripts --no-autoloader
RUN npm ci

# Copy application
COPY --chown=appuser:appgroup . .

# Finish composer install
RUN composer dump-autoload

# Copy entrypoint
COPY docker/entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

# Set permissions
RUN chown -R appuser:appgroup storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

EXPOSE 8000 5173

ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]