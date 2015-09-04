FROM wordpress
MAINTAINER Erik Wichern <ewichern@gmail.com>
RUN curl -O https://raw.githubusercontent.com/wp-cli/builds/gh-pages/phar/wp-cli.phar && chmod +x wp-cli.phar && mv wp-cli.phar /usr/local/bin/wp
RUN wp --info --allow-root

