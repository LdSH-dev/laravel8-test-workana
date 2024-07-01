FROM php:7.4-fpm

# Instalação de pacotes necessários
RUN apt-get update && apt-get install -y \
    build-essential \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    locales \
    zip \
    jpegoptim optipng pngquant gifsicle \
    vim \
    unzip \
    git \
    curl \
    supervisor

# Instalar Node.js 14 e npm
RUN curl -sL https://deb.nodesource.com/setup_14.x | bash - \
    && apt-get install -y nodejs

# Limpeza do cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Instalação de extensões PHP
RUN docker-php-ext-install pdo_mysql exif pcntl bcmath gd

# Instalação do Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Definindo o diretório de trabalho
WORKDIR /var/www

# Copiando o conteúdo do diretório de aplicação
COPY . /var/www

# Instalando dependências do npm e executando produção
RUN npm install
RUN npm run dev

# Copiando o script de entrada
COPY docker-entrypoint.sh /usr/local/bin/docker-entrypoint.sh
RUN chmod +x /usr/local/bin/docker-entrypoint.sh

# Copiando a configuração do supervisor
COPY ./supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# Adicionando usuário para aplicação Laravel
RUN groupadd -g 1000 www
RUN useradd -u 1000 -ms /bin/bash -g www www

# Ajustando permissões para o usuário www
RUN chown -R www:www /var/www

# Alterando o usuário atual para www
USER www

EXPOSE 9000

ENTRYPOINT ["docker-entrypoint.sh"]
CMD ["php-fpm"]
