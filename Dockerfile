FROM php:8.3-fpm-alpine

RUN docker-php-ext-configure pdo_mysql --with-pdo-mysql=mysqlnd \
    && docker-php-ext-configure mysqli --with-mysqli=mysqlnd \
    && docker-php-ext-install pdo_mysql

RUN echo '0 1 * * * /usr/local/bin/php /var/www/html/Request.php >> /var/log/cron.log 2>&1' >> /var/spool/cron/crontabs/root

RUN chmod 0644 /etc/crontabs/root

CMD crond -f

WORKDIR /var/www/html