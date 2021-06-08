FROM brettt89/silverstripe-web:7.4-apache
ENV DOCUMENT_ROOT /var/www/html

COPY . $DOCUMENT_ROOT
WORKDIR $DOCUMENT_ROOT

# COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN install-php-extensions imagick
