FROM php:5.6-apache

MAINTAINER Max Schrimpf <code@schrimpf.ch>

ENV APACHE_LOG_DIR /var/www/html/log/ 

RUN rm -rfv /var/www/html \
    && mkdir /var/www/html

COPY apache.conf /etc/apache2/sites-available/

RUN yes | pecl install xdebug \
    && echo "zend_extension=$(find /usr/local/lib/php/extensions/ -name xdebug.so)" > /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.remote_enable=on" >> /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.remote_autostart=off" >> /usr/local/etc/php/conf.d/xdebug.ini

RUN touch /usr/local/etc/php/conf.d/uploads.ini \
    && echo "upload_max_filesize = 10M;" >> /usr/local/etc/php/conf.d/uploads.ini


RUN mkdir -p $APACHE_LOG_DIR\
    && mkdir -p /etc/ssl/domain/private/ \
    && mkdir -p /etc/apache2/ssl.crt/ \
    && echo "" > $APACHE_LOG_DIR/markdown_blog.log \
    && chmod 666 $APACHE_LOG_DIR/markdown_blog.log \
    && a2enmod rewrite \
    && a2enmod ssl \
    && a2enmod headers \
    && apt-get -y update --force-yes \
    && apt-get install -y ca-certificates \
    && apt-get install -y openssl \
    && update-ca-certificates \
    && apt-get install -y imagemagick \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* \
    && cp /etc/ssl/certs/ca-certificates.crt /etc/apache2/ssl.crt/ca-bundle.crt \
    && openssl req -x509 -newkey rsa:4096 -keyout /etc/ssl/domain/private/domain.key -out /etc/ssl/domain/domain.pem -days 365 -nodes -subj "/C=CH/ST=Zuerich/L=Zuerich/O=Markdown_blog/OU=IT Department/CN=markdown_blog" \
    && cp /etc/ssl/domain/domain.pem /etc/ssl/domain/intermediate.pem \
    && rm -vf /etc/apache2/sites-enabled/* \
    && ln -s /etc/apache2/sites-available/apache.conf /etc/apache2/sites-enabled/ 

VOLUME ["$APACHE_LOG_DIR"]
VOLUME ["/etc/ssl/domain"]
VOLUME ["/etc/ssl/domain/private"]
VOLUME ["/etc/apache2/ssl.crt"]

COPY config /var/www/html/config
COPY public /var/www/html/public
COPY src /var/www/html/src

RUN chown -R www-data:www-data /var/www/html/

VOLUME ["/var/www/html/public/content"]
VOLUME ["/var/www/html/config"]
VOLUME ["/var/www/html/public/agent"]

EXPOSE 80
EXPOSE 443

CMD ["apache2-foreground"]




