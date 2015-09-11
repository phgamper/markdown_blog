FROM php:5.6-apache

MAINTAINER Max Schrimpf <code@schrimpf.ch>

ENV APACHE_LOG_DIR /var/log/httpd

RUN rm -rfv /var/www/html \
    && mkdir /var/www/html

# COPY config/php.ini /usr/local/etc/php
COPY apache.conf /etc/apache2/sites-available/
COPY config /var/www/html/config
COPY public /var/www/html/public
COPY src /var/www/html/src

RUN mkdir -p /var/www/html/log/ \
    && mkdir -p /etc/ssl/certs/ \
    && mkdir -p /etc/ssl/private/ \
    && mkdir -p /etc/apache2/ssl.crt/ \
    && echo "" > /var/www/html/log/default.log \
    && chmod 777 /var/www/html/log/default.log \
    && chown -R www-data:www-data /var/www/html/  \
    && mkdir /var/log/httpd \
    && a2enmod rewrite \
    && a2enmod ssl \
    && a2enmod headers \
    && apt-get -y update \
    && apt-get install -y ca-certificates \
    && update-ca-certificates \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* \
    && cp /etc/ssl/certs/ca-certificates.crt /etc/apache2/ssl.crt/ca-bundle.crt \
    && openssl req -x509 -newkey rsa:4096 -keyout /etc/ssl/private/domain.key -out /etc/ssl/certs/domain.pem -days 365 -nodes -subj "/C=CH/ST=Zuerich/L=Zuerich/O=Markdown_blog/OU=IT Department/CN=markdown_blog" \
    && cp /etc/ssl/certs/domain.pem /etc/ssl/certs/intermediate.pem \
    && rm -vf /etc/apache2/sites-enabled/* \
    && ln -s /etc/apache2/sites-available/apache.conf /etc/apache2/sites-enabled/ 

VOLUME ["/etc/ssl/certs"]
VOLUME ["/etc/ssl/private"]
VOLUME ["/etc/apache2/ssl.crt"]
VOLUME ["/var/log/httpd"]
VOLUME ["/var/www/html/public/content"]
VOLUME ["/var/www/html/config"]

EXPOSE 80
EXPOSE 443

CMD ["apache2-foreground"]
