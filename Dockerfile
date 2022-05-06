FROM brettt89/silverstripe-web:8.0-apache
ENV DOCUMENT_ROOT /var/www/html

COPY . $DOCUMENT_ROOT
WORKDIR $DOCUMENT_ROOT

# COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN curl -L https://github.com/axllent/ssbak/releases/latest/download/ssbak_linux_amd64.tar.gz --create-dirs -o ~/bin/ssbak.tar.gz && tar -xf ~/bin/ssbak.tar.gz -C ~/bin/ && rm ~/bin/ssbak.tar.gz

RUN apt-get clean
RUN apt-get update

### --- building vips-start ---
WORKDIR /usr/local/src
ARG VIPS_URL=https://github.com/libvips/libvips/releases/download
ARG VIPS_VERSION=8.12.2

RUN apt-get install -y \
    glib-2.0-dev \
    libheif-dev \
    libexpat-dev \
    librsvg2-dev \
    libpng-dev \
    libpoppler-glib-dev \
    libgif-dev \
    libjpeg-dev \
    libexif-dev \
    liblcms2-dev \
    libtiff-dev \
    libwebp-dev \
    wget \
    liborc-dev

RUN apt-get install -y \
    build-essential \
    pkg-config

RUN wget $VIPS_URL/v$VIPS_VERSION/vips-$VIPS_VERSION.tar.gz \
    && tar xf vips-$VIPS_VERSION.tar.gz \
    && cd vips-$VIPS_VERSION \
    && ./configure --prefix=/usr/local \
    && make V=0 \
    && make install

RUN pecl install vips \
    && docker-php-ext-enable vips
### --- vips-end ---

RUN apt-get install -y \
    git \
    gnupg \
    less \
    libfreetype6-dev \
    libjpeg-dev \
    libjpeg62-turbo \
    libpng-dev \
    libxml2-dev \
    libxpm4 \
    libzip-dev \
    openssh-client \
    rsync \
    tzdata \
    unzip \
    vim \
    # wget \
    zsh

RUN pecl install xdebug \
    && docker-php-ext-enable xdebug

RUN install-php-extensions \
    bcmath \
    exif \
    gd \
    gmp \
    imagick \
    intl \
    ldap \
    mysqli \
    opcache \
    pdo \
    pdo_mysql \
    soap \
    tidy \
    yaml \
    xsl \
    zip

RUN apt-get clean \
    && apt-get autoremove -y
