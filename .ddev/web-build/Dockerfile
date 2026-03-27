# Install phpactor PHAR into the container from GitHub releases
RUN curl -sLo /usr/local/bin/phpactor https://github.com/phpactor/phpactor/releases/latest/download/phpactor.phar \
    && chmod +x /usr/local/bin/phpactor \
    && (phpactor --version || true)
RUN npm i -g @biomejs/biome@2
RUN apt-get install -y codespell
