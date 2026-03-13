# Stage 1: Builder
FROM php:8.2-cli as builder

WORKDIR /app
# Copy all project files into the builder container
COPY . .

# (Any future build processes like compiling frontend assets would go here)

# Stage 2: Production
FROM php:8.2-apache

# Install runtime dependencies (Postgres driver)
RUN apt-get update && apt-get install -y \
    libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql \
    && a2enmod rewrite

# Set working directory
WORKDIR /var/www/html

# Copy application files from the builder stage
COPY --from=builder /app /var/www/html

# Set permissions for Apache user
RUN mkdir -p /var/www/html/uploads \
    && chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html \
    && chmod -R 775 /var/www/html/uploads

# Expose port 80
EXPOSE 80
