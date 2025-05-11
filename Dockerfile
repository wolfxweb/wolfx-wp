FROM wordpress:latest

# Instala extensões PHP adicionais ou outras dependências necessárias
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd

# Copia os arquivos locais do WordPress para o container
COPY ./wordpress /var/www/html

# Define permissões corretas
RUN chown -R www-data:www-data /var/www/html
