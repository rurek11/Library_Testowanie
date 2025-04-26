################################################################################
# STAGE 1 – gotowy Composer (oficjalny obraz)                                  #
################################################################################
FROM composer:2 AS composer

################################################################################
# STAGE 2 – właściwy obraz aplikacji PHP                                       #
################################################################################
FROM php:8.2-apache

###############################################################################
# 1. Ustawienia i rozszerzenia PHP                                             #
###############################################################################
# – git i unzip przydadzą się Composerowi
# – instalujemy tylko pdo_mysql (samo włącza PDO)
RUN apt-get update \
    && apt-get install -y git unzip \
    && docker-php-ext-install pdo_mysql \
    && rm -rf /var/lib/apt/lists/*

###############################################################################
# 2. Apache – zmiana DocumentRoot + mod_rewrite                                #
###############################################################################
ENV APACHE_DOCUMENT_ROOT=/var/www/public

# Podmieniamy ścieżki w vhoście i głównej konfiguracji
RUN sed -ri 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' \
    /etc/apache2/sites-available/000-default.conf \
    /etc/apache2/apache2.conf && \
    sed -ri 's!<Directory /var/www/>!<Directory ${APACHE_DOCUMENT_ROOT}/>!g' \
    /etc/apache2/apache2.conf && \
    a2enmod rewrite

RUN echo '<Directory /var/www/public>\n    AllowOverride All\n    Require all granted\n</Directory>' > /etc/apache2/conf-available/allowoverride.conf \
    && a2enconf allowoverride

# niepotzrebna poprawka
# RUN echo "AddType application/javascript .js .mjs" \
#     > /etc/apache2/conf-available/js-mime.conf \
#     && a2enconf js-mime

###############################################################################
# 3. Composer – kopiujemy binarkę z pierwszego etapu                           #
###############################################################################
COPY --from=composer /usr/bin/composer /usr/bin/composer

###############################################################################
# 4. Katalog roboczy i instalacja vendor/ (cache warstw)                       #
###############################################################################
WORKDIR /var/www

# Najpierw tylko pliki zależności → cache dla kolejnych buildów
COPY composer.json composer.lock* ./
RUN composer install --no-dev --prefer-dist --no-interaction --no-progress

###############################################################################
# 5. Dopiero teraz cały kod źródłowy                                           #
###############################################################################
COPY . .

# Uprawnienia (jeśli pracujesz na Linuxie bezvolumenowo)
RUN chown -R www-data:www-data /var/www

EXPOSE 80