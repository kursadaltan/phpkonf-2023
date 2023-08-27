FROM php:8.2-cli-alpine

RUN apk update && \
    apk add wget libpng-dev libxml2-dev alien supervisor nano busybox-suid openrc && \
    apk --no-cache add curl  && \
    apk upgrade

COPY docker/supervisor/default.conf /etc/supervisor/supervisord.conf
RUN mkdir /etc/supervisor/conf.d 
COPY docker/supervisor/conf/*.conf /etc/supervisor/conf.d/
RUN mkdir /etc/supervisor/logs && touch /etc/supervisor/logs/supervisord.log && chmod -R 777 /etc/supervisor

RUN curl -sS https://getcomposer.org/installer -o composer-setup.php && php composer-setup.php --install-dir=/usr/local/bin --filename=composer

COPY docker/script/entrypoint.sh /usr/src/entrypoint.sh
RUN chmod -R 755 /usr/src/entrypoint.sh

COPY . /usr/src/app
WORKDIR /usr/src/app

RUN composer install

CMD ["/usr/src/entrypoint.sh"]

EXPOSE 9066