FROM php:8.2-apache

# Install mysqli extension (usually included, but ensure it's enabled)
RUN docker-php-ext-install mysqli pdo_mysql

# Copy application code to the container
COPY . /var/www/html/

# Set working directory
WORKDIR /var/www/html/

# Enable Apache rewrite module (useful for clean URLs if needed)
RUN a2enmod rewrite

# Set permissions for uploads directory (for photos/audio in your project)
RUN chown -R www-data:www-data /var/www/html/Uploads \
    && chmod -R 755 /var/www/html/Uploads

# Expose port 80 for web traffic
EXPOSE 80

# Start Apache
CMD ["apache2-foreground"]