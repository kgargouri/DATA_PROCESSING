FROM php:8.3-cli

# Installer les dépendances
RUN apt-get update \
    && apt-get install -y --no-install-recommends \
        locales apt-utils git libicu-dev g++ libpng-dev libxml2-dev libzip-dev libonig-dev libxslt-dev unzip libpq-dev nodejs npm wget curl \
        apt-transport-https lsb-release ca-certificates \
    && rm -rf /var/lib/apt/lists/*

# Configurer les locales
RUN echo "en_US.UTF-8 UTF-8" > /etc/locale.gen \
    && echo "fr_FR.UTF-8 UTF-8" >> /etc/locale.gen \
    && locale-gen

# Installer Composer
RUN curl -sS https://getcomposer.org/installer | php -- \
    && mv composer.phar /usr/local/bin/composer

# Installer Symfony CLI
RUN curl -sS https://get.symfony.com/cli/installer | bash \
    && mv /root/.symfony*/bin/symfony /usr/local/bin/symfony \
    && chmod +x /usr/local/bin/symfony  # Assurez-vous que le binaire est exécutable

# Installer les extensions PHP
RUN docker-php-ext-configure intl \
    && docker-php-ext-install \
        pdo pdo_mysql pdo_pgsql opcache intl zip calendar dom mbstring gd xsl

# Installer APCu
RUN pecl install apcu && docker-php-ext-enable apcu

# Installer Yarn
RUN npm install --global yarn

# Configurer Git
RUN git config --global user.email "karim_gargouri@live.fr" \
    && git config --global user.name "kgargouri"

# Maintenir le conteneur en cours d'exécution
CMD tail -f /dev/null

# Définir le répertoire de travail
WORKDIR /var/www/html/

EXPOSE 8000