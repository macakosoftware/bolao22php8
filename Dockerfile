FROM php:8.1.10-fpm-alpine

# Copy composer.lock and composer.json
COPY composer.lock composer.json /var/www/

# Set working directory
WORKDIR /var/www

# install necessary alpine packages
RUN apk update && apk add --no-cache \
    zip \
    unzip \
    dos2unix \
    supervisor \
    libpng-dev libwebp-dev libjpeg-turbo-dev freetype-dev \
    libzip-dev \
    $PHPIZE_DEPS

# configure packages
RUN docker-php-ext-configure gd --with-freetype --with-jpeg
    
# compile native PHP packages
RUN docker-php-ext-install \
    gd \
    pcntl \
    bcmath \
    mysqli \
    pdo_mysql
    


# install additional packages from PECL
RUN pecl install zip && docker-php-ext-enable zip \
    && pecl install igbinary && docker-php-ext-enable igbinary \
    && yes | pecl install redis && docker-php-ext-enable redis \
    && pecl install pcov \
    && docker-php-ext-enable pcov


# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Copy existing application directory contents
COPY . /var/www

COPY ./start.sh /usr/local/bin/start

RUN chmod u+x /usr/local/bin/start

# Copy existing application directory permissions
COPY --chown=www:www . /var/www

# Change current user to www
# USER www

# Expose port 9000 and start php-fpm server
EXPOSE 9000
CMD ["/usr/local/bin/start"]