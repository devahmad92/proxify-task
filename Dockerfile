FROM alpine:3.12

# Install packages
RUN apk --no-cache add php7 php7-fpm php7-mysqli php7-json php7-openssl php7-curl php7-pcntl php7-bcmath \
    php7-zlib php7-xml php7-phar php7-intl php7-dom php7-xmlreader php7-ctype php7-session php7-pdo php7-exif \
    php7-mbstring php7-gd php7-pdo_mysql php7-xmlwriter php7-redis php7-tokenizer php7-fileinfo php7-simplexml \
    php7-zip php7-iconv nginx supervisor composer curl git

# Configure nginx
COPY bin/nginx.conf /etc/nginx/nginx.conf

# Remove default server definition
RUN rm /etc/nginx/conf.d/default.conf

# Configure PHP-FPM
COPY bin/fpm-pool.conf /etc/php7/php-fpm.d/www.conf

# Configure PHP-INI
COPY bin/php.ini /etc/php7/conf.d/custom.ini

# Configure supervisord
COPY bin/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# Setup document root and setup composer cache directory and psysh config file
RUN mkdir -p /var/www/html && mkdir -p /.composer && mkdir -p /.config/psysh

# Make sure files/folders needed by the processes are accessable when they run under the nobody user
RUN chown -R nobody.nobody /var/www/html && \
  chown -R nobody.nobody /.composer && \
  chown -R nobody.nobody /run && \
  chown -R nobody.nobody /.config/psysh && \
  chown -R nobody.nobody /var/lib/nginx && \
  chown -R nobody.nobody /var/log/nginx

# Switch to use a non-root user from here on
USER nobody

# Define working directory
WORKDIR /var/www/html

# Adding the application folders/files
COPY --chown=nobody . .

# Install composer dependencies
RUN composer install \
    --no-interaction \
    --no-scripts \
    --no-suggest \
    --no-dev \
    --optimize-autoloader

# Expose the port nginx is reachable on
EXPOSE 8080

# Let supervisord start nginx & php-fpm
CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]

# Configure a healthcheck to validate that everything is up&running
HEALTHCHECK --timeout=10s CMD curl --silent --fail http://127.0.0.1:8080/fpm-ping
