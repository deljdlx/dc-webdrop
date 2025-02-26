FROM php:8.3-alpine

# install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# install ratchet globally
RUN composer require cboden/ratchet

RUN mkdir /app

COPY entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh

EXPOSE 8443

ENTRYPOINT ["/bin/sh", "-c", "/entrypoint.sh"]

