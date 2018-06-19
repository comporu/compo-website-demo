FROM nginx

RUN export DEBIAN_FRONTEND=noninteractive DEBCONF_NONINTERACTIVE_SEEN=true && apt-get update && apt-get install -y \
    openssl \
    ssl-cert

COPY "nginx.conf" "/etc/nginx/conf.d/default.conf"

WORKDIR /var/www/html
