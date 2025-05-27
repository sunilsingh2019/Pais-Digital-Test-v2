FROM php:8.1-apache

# Enable Apache mod_rewrite
RUN a2enmod rewrite

# Install any additional PHP extensions if needed
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Set working directory
WORKDIR /var/www/html

# Copy application files
COPY . /var/www/html/

# Set proper permissions
RUN chown -R www-data:www-data /var/www/html
RUN chmod -R 755 /var/www/html

EXPOSE 80 