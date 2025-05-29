FROM wordpress:latest

# Instala extensões PHP adicionais e dependências
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd \
    && docker-php-ext-install mysqli pdo pdo_mysql \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Configurações de PHP para melhor performance
RUN { \
    echo 'memory_limit = 512M'; \
    echo 'upload_max_filesize = 256M'; \
    echo 'post_max_size = 256M'; \
    echo 'max_execution_time = 600'; \
    echo 'max_input_vars = 3000'; \
} > /usr/local/etc/php/conf.d/custom.ini

# Copia os arquivos locais do WordPress para o container
COPY ./wordpress /var/www/html

# Define permissões corretas
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

# Configurações de segurança
RUN { \
    echo 'ServerTokens Prod'; \
    echo 'ServerSignature Off'; \
    echo 'TraceEnable Off'; \
} >> /etc/apache2/conf-available/security.conf

# Limpa cache e arquivos temporários
RUN rm -rf /var/www/html/wp-content/cache/* \
    && rm -rf /var/www/html/wp-content/uploads/cache/*

# Install Node.js and npm
RUN apt-get update && \
    apt-get install -y curl gnupg && \
    curl -fsSL https://deb.nodesource.com/setup_20.x | bash - && \
    apt-get install -y nodejs && \
    apt-get clean && \
    rm -rf /var/lib/apt/lists/*

# Verify installations
RUN node --version && npm --version

# Set working directory
WORKDIR /var/www/html

# Copy WordPress files
COPY wordpress/ /var/www/html/

# Set permissions
RUN chown -R www-data:www-data /var/www/html
