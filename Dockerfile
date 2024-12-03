# Usar a imagem oficial do PHP com FPM e PHP 8.2
FROM php:8.2-fpm

# Instalar dependências do sistema
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    zip \
    libzip-dev \
    unzip \
    git \
    curl

# Instalar extensões PHP necessárias
RUN docker-php-ext-configure gd --with-freetype --with-jpeg && \
    docker-php-ext-install gd pdo pdo_mysql zip

# Instalar o Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Definir o diretório de trabalho
WORKDIR /var/www

# Copiar o código da aplicação Laravel
COPY . .

# Instalar dependências do Laravel
RUN composer install

# Definir permissões
RUN chown -R www-data:www-data /var/www \
    && chmod -R 755 /var/www/storage

# Expor a porta do PHP-FPM
EXPOSE 9000

CMD ["php-fpm"]
