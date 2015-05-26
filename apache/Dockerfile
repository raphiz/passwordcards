FROM raphiz/drone-php:5.5.20

RUN apt-get -yqq update
RUN apt-get -yqq install libcurl4-gnutls-dev zlib1g-dev
RUN apt-get -yqq install lftp
RUN docker-php-ext-install curl zip

# Set Timezone
RUN echo 'date.timezone = "Europe/Zurich"' > /usr/local/etc/php/conf.d/timezone.ini

# Remove warning PHP Warning:  Module 'curl' already loaded in Unknown on line 0
RUN rm /usr/local/etc/php/conf.d/ext-curl.ini
