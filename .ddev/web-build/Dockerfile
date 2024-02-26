RUN sed -i 's/^;opcache.enable_cli=/opcache.enable_cli=1/' /etc/php/8.2/cli/php.ini \
    && sed -i 's/^;opcache.blacklist_filename=/opcache.blacklist_filename=\/var\/www\/html\/blacklist.txt/' /etc/php/8.2/cli/php.ini \
    && sed -i 's/^;opcache.file_cache=/opcache.file_cache=\/var\/tmp\//' /etc/php/8.2/cli/php.ini \
    && sed -i 's/^;opcache.file_cache_only=/opcache.file_cache_only=1/' /etc/php/8.2/cli/php.ini \
    && sed -i 's/^;opcache.file_cache_consistency_checks=/opcache.file_cache_consistency_checks=1/' /etc/php/8.2/cli/php.ini

RUN --mount=type=ssh,uid=${uid},gid=${gid},target=/run/host-services/ssh-auth.sock
