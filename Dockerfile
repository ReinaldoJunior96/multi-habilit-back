# Usar a imagem oficial do PHP com FPM e PHP 8.3
FROM php:8.3-fpm

# Instalar dependências do sistema
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    zip \
    libzip-dev \
    unzip \
    git \
    curl \
    supervisor && \
    docker-php-ext-configure gd --with-freetype --with-jpeg && \
    docker-php-ext-install gd pdo pdo_mysql zip pcntl

# Instalar o Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Definir o diretório de trabalho
WORKDIR /var/www

# Copiar o código da aplicação Laravel
COPY . .

# Instalar dependências do Laravel
RUN composer install --no-dev --optimize-autoloader

# Definir permissões
RUN chown -R www-data:www-data /var/www \
    && chmod -R 755 /var/www/storage

# Copiar o arquivo de configuração do Supervisor
COPY .docker/supervisor/supervisor.conf /etc/supervisor/conf.d/supervisor.conf

# Expor as portas do PHP-FPM e do WebSocket
EXPOSE 9000 8080

# Comando para iniciar o Supervisor
CMD ["supervisord", "-c", "/etc/supervisor/conf.d/supervisor.conf"]
