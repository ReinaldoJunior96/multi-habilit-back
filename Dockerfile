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
    supervisor \
    cron \
    procps \  
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo pdo_mysql zip pcntl

# Instalar o Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Definir o diretório de trabalho
WORKDIR /var/www

# Copiar o código da aplicação Laravel
COPY . .

# Instalar dependências do Laravel
RUN composer install --no-dev --optimize-autoloader

# Criar diretórios necessários para o Supervisor
RUN mkdir -p /var/run/supervisor /var/log/supervisor && \
    chmod -R 755 /var/run/supervisor /var/log/supervisor

# Definir permissões
RUN chown -R www-data:www-data /var/www \
    && chmod -R 755 /var/www/storage

# Copiar o arquivo de configuração do Supervisor
COPY .docker/supervisor/supervisor.conf /etc/supervisor/conf.d/supervisor.conf

# Criar um arquivo crontab para rodar o Laravel Scheduler a cada minuto
RUN echo "SHELL=/bin/bash" > /etc/cron.d/laravel-cron \
    && echo "PATH=/usr/local/bin:/usr/bin:/bin" >> /etc/cron.d/laravel-cron \
    && echo "* * * * * /usr/local/bin/php /var/www/artisan schedule:run >> /var/log/cron_laravel.log 2>&1" >> /etc/cron.d/laravel-cron \
    && chmod 0644 /etc/cron.d/laravel-cron \
    && crontab /etc/cron.d/laravel-cron

# Expor as portas do PHP-FPM e do WebSocket
EXPOSE 9000 8080

# Inicializar o Supervisor e o Cron no container
CMD cron && /usr/bin/supervisord -n -c /etc/supervisor/conf.d/supervisor.conf

