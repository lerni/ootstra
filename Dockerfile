FROM brettt89/silverstripe-web:7.4-apache
ENV DOCUMENT_ROOT /var/www/html

COPY . $DOCUMENT_ROOT
WORKDIR $DOCUMENT_ROOT

# COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN curl -L https://github.com/axllent/ssbak/releases/latest/download/ssbak_linux_amd64.tar.gz --create-dirs -o ~/bin/ssbak.tar.gz && tar -xf ~/bin/ssbak.tar.gz -C ~/bin/ && rm ~/bin/ssbak.tar.gz

RUN apt-get update

RUN apt install --assume-yes openssh-client

RUN apt install --assume-yes vim

RUN install-php-extensions imagick
