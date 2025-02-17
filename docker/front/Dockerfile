FROM tangramor/nginx-php8-fpm:latest

COPY entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh
RUN npm install -g wscat
RUN composer require cboden/ratchet

ENTRYPOINT ["/bin/sh", "-c", "/entrypoint.sh"]
