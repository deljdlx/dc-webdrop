#!/bin/sh

cd /var/www/html

if [ ! -d /var/www/html/vendor ]; then
    echo "Installing composer dependencies"
    composer install
else
    echo "Composer dependencies already installed"
fi

if [ ! -f /var/www/html/var/data.sqlite ]; then
    cp /var/www/html/_provisions/data.sqlite /var/www/html/var/data.sqlite
    echo "Database file copied"
else
    echo "Database file already exists"
fi

echo "Setting permissions"
chown -R nginx:nginx /var/www/html/var
chmod -R 775 /var/www/html/var

echo "Waiting for database to be ready..."
php bin/console doctrine:migrations:migrate --no-interaction

php-fpm83 -D
nginx -g 'daemon off;'
