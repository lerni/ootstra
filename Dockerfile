FROM brettt89/silverstripe-web:8.0-apache
ENV DOCUMENT_ROOT /var/www/html

COPY . $DOCUMENT_ROOT
WORKDIR $DOCUMENT_ROOT

# COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN curl -L https://github.com/mailhog/mhsendmail/releases/latest/download/mhsendmail_linux_amd64 --create-dirs -o /usr/local/bin/mhsendmail && chmod +x /usr/local/bin/mhsendmail

# RUN curl -L https://squizlabs.github.io/PHP_CodeSniffer/phpcs.phar --create-dirs -o /usr/local/bin/phpcs && chmod +x /usr/local/bin/phpcs
# RUN curl -L https://squizlabs.github.io/PHP_CodeSniffer/phpcbf.phar --create-dirs -o /usr/local/bin/phpcbf && chmod +x /usr/local/bin/phpcbf
# RUN curl -L https://github.com/phpstan/phpstan/releases/latest/download/phpstan.phar --create-dirs -o /usr/local/bin/phpstan && chmod +x /usr/local/bin/phpstan

RUN apt-get update

### --- building vips-start ---
# RUN apt install --assume-yes openssh-client
# WORKDIR /usr/local/src
# ARG VIPS_URL=https://github.com/libvips/libvips/releases/download
# ARG VIPS_VERSION=8.13.3

# RUN apt-get install -y \
#     glib-2.0-dev \
#     libheif-dev \
#     libexpat-dev \
#     librsvg2-dev \
#     libpng-dev \
#     libpoppler-glib-dev \
#     libgif-dev \
#     libjpeg-dev \
#     libexif-dev \
#     liblcms2-dev \
#     libtiff-dev \
#     libwebp-dev \
#     wget \
#     liborc-dev

# RUN apt-get install -y \
#     build-essential \
#     pkg-config

# RUN wget $VIPS_URL/v$VIPS_VERSION/vips-$VIPS_VERSION.tar.gz \
#     && tar xf vips-$VIPS_VERSION.tar.gz \
#     && cd vips-$VIPS_VERSION \
#     && ./configure --prefix=/usr/local \
#     && make V=0 \
#     && make install

# RUN pecl install vips \
#     && docker-php-ext-enable vips
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
    mariadb-client \
    tzdata \
    unzip \
    vim \
    wget \
    wkhtmltopdf \
    zsh

RUN pecl install xdebug \
    && docker-php-ext-enable xdebug

RUN install-php-extensions \
    imagick \
    yaml

RUN apt-get clean \
    && apt-get autoremove -y

RUN rm /var/log/apache2/error.log
RUN rm /var/log/apache2/other_vhosts_access.log
# RUN touch /var/log/xdebug.log

RUN rm /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini
RUN rm /usr/local/etc/php/conf.d/timezone.ini

# Uses "agnoster" theme for better distingusion of local & container-shell
RUN sh -c "$(wget -O- https://github.com/deluan/zsh-in-docker/releases/download/v1.1.2/zsh-in-docker.sh)" -- \
    -t agnoster
# RUN wget https://github.com/robbyrussell/oh-my-zsh/raw/master/tools/install.sh -O - | zsh || true

# Add aliases to /root/.zshrc
RUN sed -i '1 a alias flush="'$DOCUMENT_ROOT'/vendor/silverstripe/framework/sake flush"' /root/.zshrc \
 && sed -i '1 a alias flushh="rm -rf '$DOCUMENT_ROOT'/silverstripe-cache/*"' /root/.zshrc \
 && sed -i '1 a alias dbuild="'$DOCUMENT_ROOT'/vendor/silverstripe/framework/sake dev/build"' /root/.zshrc \
 && sed -i '1 a alias dep="'$DOCUMENT_ROOT'/vendor/bin/dep"' /root/.zshrc \
 && sed -i '1 a alias up="cd ../.."' /root/.zshrc
