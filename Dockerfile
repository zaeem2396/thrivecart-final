FROM php:8.2-apache
WORKDIR /var/www/html
COPY . .
RUN docker-php-ext-install pdo pdo_mysql
CMD ["php", "artisan", "serve", "--host=0.0.0.0"]
EXPOSE 8000
