FROM php:7.2-fpm

RUN export DEBIAN_FRONTEND=noninteractive DEBCONF_NONINTERACTIVE_SEEN=true && apt-get update && apt-get install -y \
    openssl \
    git \
    unzip \
    gnupg \
    sudo \
    supervisor \
    libmemcached-dev \
    libicu-dev \
    libpng-dev \
    libfreetype6-dev \
    libjpeg-dev \
    libxpm-dev \
    libwebp-dev

RUN docker-php-ext-configure gd \
    --with-freetype-dir=/usr/include/ \
    --with-jpeg-dir=/usr/include/ \
    --with-xpm-dir=/usr/include \
    --with-webp-dir=/usr/include/

# Type docker-php-ext-install to see available extensions
RUN docker-php-ext-install pdo pdo_mysql intl gd bcmath zip opcache

RUN pecl install --force apcu-beta  \
  && docker-php-ext-enable apcu

RUN pecl install --force memcached  \
  && docker-php-ext-enable memcached

COPY "php.ini" "/usr/local/etc/php/conf.d/php.ini"

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN curl -LO https://deployer.org/deployer.phar
RUN mv deployer.phar /usr/local/bin/dep
RUN chmod +x /usr/local/bin/dep

RUN curl -sL https://deb.nodesource.com/setup_8.x | bash - \
    && apt-get install -y nodejs \
    && npm install -g bower

RUN ln -s /var/www/html/docker/php/php-fpm.conf /usr/local/etc/php-fpm.d/zz-project.conf
RUN ln -s /var/www/html/docker/php/supervisord.conf /etc/supervisord.conf

RUN useradd -ms /bin/bash vagrant

RUN usermod -u 1000 vagrant && groupmod -g 1000 vagrant

RUN usermod -aG sudo vagrant

RUN echo '%sudo ALL=(ALL) NOPASSWD:ALL' >> /etc/sudoers


RUN chown vagrant:vagrant -R /var/log/supervisor/

USER vagrant

WORKDIR /var/www/html

