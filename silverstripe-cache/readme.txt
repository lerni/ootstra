With this ddev-setup, this folder won't sync with what's inside the web container. It's mounted as tmpfs - in ram for performance.

If you need to wipe it out, run the command below or "ddev restart" or use the flushh (flush hard).

ddev exec \"rm -rf /var/www/html/silverstripe-cache/*\" && php -r 'opcache_reset();'
