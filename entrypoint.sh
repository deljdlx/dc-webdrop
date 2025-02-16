#!/bin/sh
set -e

ls -al /var/www/html

cd /var/www/server && php run.php &

exec /start.sh
