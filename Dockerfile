FROM php:5.6-apache

MAINTAINER Max Schrimpf <code@schrimpf.ch>

ENV APACHE_LOG_DIR /var/www/html/log/ 

RUN rm -rfv /var/www/html \
    && mkdir /var/www/html

# COPY config/php.ini /usr/local/etc/php
COPY apache.conf /etc/apache2/sites-available/

RUN mkdir -p $APACHE_LOG_DIR\
    && mkdir -p /etc/ssl/domain/private/ \
    && mkdir -p /etc/apache2/ssl.crt/ \
    && echo "" > $APACHE_LOG_DIR/default.log \
    && chmod 664 $APACHE_LOG_DIR/default.log \
    && a2enmod rewrite \
    && a2enmod ssl \
    && a2enmod headers \
    && apt-get -y update \
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

EXPOSE 80
EXPOSE 443

CMD ["apache2-foreground"]
