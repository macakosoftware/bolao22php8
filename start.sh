#!/bin/sh
set -e

printf "\n\n Startando PHP-FPM \n\n"
php-fpm --daemonize

while [ true ]
do
    printf "\n\n Executando o scheduler do Laravel... \n\n"
    php /var/www/artisan schedule:run --verbose --no-interaction &
    printf " Aguardando 60 segundos \n"
    sleep 60
done