FROM php:8.2-apache

RUN docker-php-ext-install pdo pdo_mysql mysqli

# Skopiuj plik index.php do katalogu, który Apache widzi
COPY ./public /var/www/html

# Ustaw odpowiednie uprawnienia
RUN chown -R www-data:www-data /var/www/html