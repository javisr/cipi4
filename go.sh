#!/bin/bash

#################################################### CONFIGURATION ###
CIPI_USER_PASSWORD=$(openssl rand -base64 32|sha256sum|base64|head -c 32| tr '[:upper:]' '[:lower:]')
CIPI_DATABASE_PASSWORD=$(openssl rand -base64 24|sha256sum|base64|head -c 32| tr '[:upper:]' '[:lower:]')
CIPI_GIT_REPOSITORY=andreapollastri/cipi
if [ -z "$1" ];
    CIPI_GIT_BRANCH=latest
then
    CIPI_GIT_BRANCH=$1
fi


####################################################   CLI TOOLS   ###
reset=$(tput sgr0)
bold=$(tput bold)
underline=$(tput smul)
black=$(tput setaf 0)
white=$(tput setaf 7)
red=$(tput setaf 1)
green=$(tput setaf 2)
yellow=$(tput setaf 3)
blue=$(tput setaf 4)
purple=$(tput setaf 5)
bgblack=$(tput setab 0)
bgwhite=$(tput setab 7)
bgred=$(tput setab 1)
bggreen=$(tput setab 2)
bgyellow=$(tput setab 4)
bgblue=$(tput setab 4)
bgpurple=$(tput setab 5)


#################################################### CIPI SETUP ######

# LOGO
clear
echo "${green}${bold}"
echo ""
echo " ██████ ██ ██████  ██" 
echo "██      ██ ██   ██ ██" 
echo "██      ██ ██████  ██" 
echo "██      ██ ██      ██" 
echo " ██████ ██ ██      ██" 
echo ""
echo "Installation has been started... Hold on!"
echo "${reset}"
sleep 3s



# OS CHECK
clear
clear
echo "${bggreen}${black}${bold}"
echo "OS check..."
echo "${reset}"
sleep 1s

ID=$(grep -oP '(?<=^ID=).+' /etc/os-release | tr -d '"')
VERSION=$(grep -oP '(?<=^VERSION_ID=).+' /etc/os-release | tr -d '"')
if [ "$ID" = "ubuntu" ]; then
    case $VERSION in
        22.04)
            break
            ;;
        *)
            echo "${bgred}${white}${bold}"
            echo "Cipi requires Linux Ubuntu 22.04 LTS"
            echo "${reset}"
            exit 1;
            break
            ;;
    esac
else
    echo "${bgred}${white}${bold}"
    echo "Cipi requires Linux Ubuntu 22.04 LTS"
    echo "${reset}"
    exit 1
fi



# ROOT CHECK
clear
clear
echo "${bggreen}${black}${bold}"
echo "Permission check..."
echo "${reset}"
sleep 1s

if [ "$(id -u)" = "0" ]; then
    clear
else
    clear
    echo "${bgred}${white}${bold}"
    echo "You have to run Cipi as root. (In AWS use 'sudo -s')"
    echo "${reset}"
    exit 1
fi



# BASIC SETUP
clear
clear
echo "${bggreen}${black}${bold}"
echo "Base setup..."
echo "${reset}"
sleep 1s

sudo DEBIAN_FRONTEND=noninteractive apt-get -y update
sudo DEBIAN_FRONTEND=noninteractive apt-get -y install software-properties-common curl wget nano vim rpl sed zip unzip expect dirmngr apt-transport-https lsb-release ca-certificates dnsutils dos2unix htop



# GET IP
clear
clear
echo "${bggreen}${black}${bold}"
echo "Getting IP..."
echo "${reset}"
sleep 1s

CIPI_SERVER_IP=$(curl -s https://checkip.amazonaws.com)



# MOTD WELCOME MESSAGE
clear
echo "${bggreen}${black}${bold}"
echo "Motd settings..."
echo "${reset}"
sleep 1s

CIPI_WELCOME_FILE=/etc/motd
sudo touch $CIPI_WELCOME_FILE
sudo cat > "$CIPI_WELCOME_FILE" <<EOF

 ██████ ██ ██████  ██ 
██      ██ ██   ██ ██ 
██      ██ ██████  ██ 
██      ██ ██      ██
 ██████ ██ ██      ██

With great power comes great responsibility...

EOF



# SWAP
clear
echo "${bggreen}${black}${bold}"
echo "Memory SWAP..."
echo "${reset}"
sleep 1s

sudo /bin/dd if=/dev/zero of=/var/swap.1 bs=1M count=1024
sudo /sbin/mkswap /var/swap.1
sudo /sbin/swapon /var/swap.1



# ALIAS
clear
echo "${bggreen}${black}${bold}"
echo "Custom CLI configuration..."
echo "${reset}"
sleep 1s

shopt -s expand_aliases
alias ll='ls -alF'



# CIPI DIRS
clear
echo "${bggreen}${black}${bold}"
echo "Cipi directories..."
echo "${reset}"
sleep 1s

sudo mkdir /etc/cipi/
sudo chmod o-r /etc/cipi
sudo mkdir /var/cipi/
sudo chmod o-r /var/cipi



# USER
clear
echo "${bggreen}${black}${bold}"
echo "Cipi root user..."
echo "${reset}"
sleep 1s

sudo pam-auth-update --package
sudo mount -o remount,rw /
sudo chmod 640 /etc/shadow
sudo useradd -m -s /bin/bash cipi
echo "cipi:$CIPI_USER_PASSWORD"|sudo chpasswd
sudo usermod -aG sudo cipi



# NGINX
clear
echo "${bggreen}${black}${bold}"
echo "nginx setup..."
echo "${reset}"
sleep 1s

sudo DEBIAN_FRONTEND=noninteractive apt-get -y update
sudo DEBIAN_FRONTEND=noninteractive apt-get -y install nginx
sudo DEBIAN_FRONTEND=noninteractive apt-get -y install nginx-extras
sudo systemctl start nginx.service
sudo rpl "http {" "http { \\n   limit_req_zone \$binary_remote_addr zone=one:10m rate=1r/s; fastcgi_read_timeout 300; \\n   more_set_headers 'Server: Managed by cipi.sh';" /etc/nginx/nginx.conf
sudo systemctl enable nginx.service
sudo systemctl restart nginx.service



# FIREWALL
clear
echo "${bggreen}${black}${bold}"
echo "fail2ban setup..."
echo "${reset}"
sleep 1s

sudo DEBIAN_FRONTEND=noninteractive apt-get -y update
sudo DEBIAN_FRONTEND=noninteractive apt-get -y install fail2ban
CIPI_JAIL_FILE=/etc/fail2ban/jail.local
sudo unlink CIPI_JAIL_FILE
sudo touch $CIPI_JAIL_FILE
sudo cat > "$CIPI_JAIL_FILE" <<EOF
[DEFAULT]
bantime = 3600
banaction = iptables-multiport
[sshd]
enabled = true
logpath  = /var/log/auth.log
EOF
sudo systemctl restart fail2ban
sudo ufw --force enable
sudo ufw allow ssh
sudo ufw allow http
sudo ufw allow https
sudo ufw allow "Nginx Full"



# PHP
clear
echo "${bggreen}${black}${bold}"
echo "PHP setup..."
echo "${reset}"
sleep 1s

sudo DEBIAN_FRONTEND=noninteractive add-apt-repository -y ppa:ondrej/php
sudo DEBIAN_FRONTEND=noninteractive apt-get -y update
sudo DEBIAN_FRONTEND=noninteractive apt-get -y install php8.1-fpm
sudo DEBIAN_FRONTEND=noninteractive apt-get -y install php8.1-common
sudo DEBIAN_FRONTEND=noninteractive apt-get -y install php8.1-curl
sudo DEBIAN_FRONTEND=noninteractive apt-get -y install php8.1-bcmath
sudo DEBIAN_FRONTEND=noninteractive apt-get -y install php8.1-mbstring
sudo DEBIAN_FRONTEND=noninteractive apt-get -y install php8.1-tokenizer
sudo DEBIAN_FRONTEND=noninteractive apt-get -y install php8.1-mysql
sudo DEBIAN_FRONTEND=noninteractive apt-get -y install php8.1-sqlite3
sudo DEBIAN_FRONTEND=noninteractive apt-get -y install php8.1-pgsql
sudo DEBIAN_FRONTEND=noninteractive apt-get -y install php8.1-redis
sudo DEBIAN_FRONTEND=noninteractive apt-get -y install php8.1-memcached
sudo DEBIAN_FRONTEND=noninteractive apt-get -y install php8.1-json
sudo DEBIAN_FRONTEND=noninteractive apt-get -y install php8.1-zip
sudo DEBIAN_FRONTEND=noninteractive apt-get -y install php8.1-xml
sudo DEBIAN_FRONTEND=noninteractive apt-get -y install php8.1-soap
sudo DEBIAN_FRONTEND=noninteractive apt-get -y install php8.1-gd
sudo DEBIAN_FRONTEND=noninteractive apt-get -y install php8.1-imagick
sudo DEBIAN_FRONTEND=noninteractive apt-get -y install php8.1-fileinfo
sudo DEBIAN_FRONTEND=noninteractive apt-get -y install php8.1-imap
sudo DEBIAN_FRONTEND=noninteractive apt-get -y install php8.1-cli
sudo DEBIAN_FRONTEND=noninteractive apt-get -y install php8.1-openssl
CIPI_PHP_INI=/etc/php/8.1/fpm/conf.d/cipi.ini
sudo touch $CIPI_PHP_INI
sudo cat > "$CIPI_PHP_INI" <<EOF
memory_limit = 256M
upload_max_filesize = 256M
post_max_size = 256M
max_execution_time = 180
max_input_time = 180
EOF
sudo service php8.1-fpm restart



# PHP CLI
clear
echo "${bggreen}${black}${bold}"
echo "PHP CLI configuration..."
echo "${reset}"
sleep 1s

sudo update-alternatives --set php /usr/bin/php8.1



# COMPOSER
clear
echo "${bggreen}${black}${bold}"
echo "Composer setup..."
echo "${reset}"
sleep 1s

php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
php composer-setup.php --no-interaction
php -r "unlink('composer-setup.php');"
mv composer.phar /usr/local/bin/composer
composer config --global repo.packagist composer https://packagist.org --no-interaction



# GIT
clear
echo "${bggreen}${black}${bold}"
echo "GIT setup..."
echo "${reset}"
sleep 1s

sudo DEBIAN_FRONTEND=noninteractive apt-get -y update
sudo DEBIAN_FRONTEND=noninteractive apt-get -y install git



# SUPERVISOR
clear
echo "${bggreen}${black}${bold}"
echo "Supervisor setup..."
echo "${reset}"
sleep 1s

sudo DEBIAN_FRONTEND=noninteractive apt-get -y update
sudo DEBIAN_FRONTEND=noninteractive apt-get -y install supervisor
sudo service supervisor restart



# DEFAULT VHOST
clear
echo "${bggreen}${black}${bold}"
echo "Default vhost..."
echo "${reset}"
sleep 1s

CIPI_NGINX_CONFIG=/etc/nginx/sites-available/default
if test -f "$CIPI_NGINX_CONFIG"; then
    sudo unlink CIPI_NGINX_CONFIG
fi
sudo touch $CIPI_NGINX_CONFIG
sudo cat > "$CIPI_NGINX_CONFIG" <<EOF
server {
    listen 80 default_server;
    listen [::]:80 default_server;
    root /var/www/html/public;
    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-XSS-Protection "1; mode=block";
    add_header X-Content-Type-Options "nosniff";
    client_body_timeout 10s;
    client_header_timeout 10s;
    client_max_body_size 256M;
    index index.html index.php;
    charset utf-8;
    server_tokens off;
    location / {
        try_files   \$uri     \$uri/  /index.php?\$query_string;
    }
    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }
    error_page 404 /index.php;
    location ~ \.php$ {
        include snippets/fastcgi-php.conf;
        fastcgi_pass unix:/var/run/php/php8.1-fpm.sock;
    }
    location ~ /\.(?!well-known).* {
        deny all;
    }
}
EOF
sudo mkdir /etc/nginx/cipi/
sudo systemctl restart nginx.service



# MYSQL
clear
echo "${bggreen}${black}${bold}"
echo "MySQL setup..."
echo "${reset}"
sleep 1s

sudo DEBIAN_FRONTEND=noninteractive apt-get -y update
sudo DEBIAN_FRONTEND=noninteractive apt-get -y install mysql-server
CIPI_SECURE_MYSQL=$(expect -c "
set timeout 10
spawn mysql_secure_installation
expect \"Press y|Y for Yes, any other key for No:\"
send \"n\r\"
expect \"New password:\"
send \"$CIPI_DATABASE_PASSOWORD\r\"
expect \"Re-enter new password:\"
send \"$CIPI_DATABASE_PASSOWORD\r\"
expect \"Remove anonymous users? (Press y|Y for Yes, any other key for No)\"
send \"y\r\"
expect \"Disallow root login remotely? (Press y|Y for Yes, any other key for No)\"
send \"n\r\"
expect \"Remove test database and access to it? (Press y|Y for Yes, any other key for No)\"
send \"y\r\"
expect \"Reload privilege tables now? (Press y|Y for Yes, any other key for No) \"
send \"y\r\"
expect eof
")
echo "$CIPI_SECURE_MYSQL"
/usr/bin/mysql -u root -p$CIPI_DATABASE_PASSOWORD <<EOF
use mysql;
CREATE USER 'cipi'@'%' IDENTIFIED WITH mysql_native_password BY '$CIPI_DATABASE_PASSOWORD';
GRANT ALL PRIVILEGES ON *.* TO 'cipi'@'%' WITH GRANT OPTION;
FLUSH PRIVILEGES;
EOF



# REDIS
clear
echo "${bggreen}${black}${bold}"
echo "Redis setup..."
echo "${reset}"
sleep 1s

sudo DEBIAN_FRONTEND=noninteractive apt-get -y update
sudo DEBIAN_FRONTEND=noninteractive apt-get -y install redis-server
sudo rpl -i -w "supervised no" "supervised systemd" /etc/redis/redis.conf
sudo systemctl restart redis.service



# LET'S ENCRYPT
clear
echo "${bggreen}${black}${bold}"
echo "Let's Encrypt setup..."
echo "${reset}"
sleep 1s

sudo DEBIAN_FRONTEND=noninteractive apt-get -y update
sudo DEBIAN_FRONTEND=noninteractive apt-get -y install certbot
sudo DEBIAN_FRONTEND=noninteractive apt-get -y install python3-certbot-nginx



# NODE
clear
echo "${bggreen}${black}${bold}"
echo "Node/npm setup..."
echo "${reset}"
sleep 1s

curl -s https://deb.nodesource.com/gpgkey/nodesource.gpg.key | sudo apt-key add -
curl -sL https://deb.nodesource.com/setup_16.x | sudo -E bash -
NODE=/etc/apt/sources.list.d/nodesource.list
sudo unlink NODE
sudo touch $CIPI_NODE_REPOSITORY
sudo cat > "$CIPI_NODE_REPOSITORY" <<EOF
deb https://deb.nodesource.com/node_16.x focal main
deb-src https://deb.nodesource.com/node_16.x focal main
EOF
sudo DEBIAN_FRONTEND=noninteractive apt-get -y update
sudo DEBIAN_FRONTEND=noninteractive apt-get -y install nodejs
sudo DEBIAN_FRONTEND=noninteractive apt-get -y install npm



#PANEL INSTALLATION
clear
echo "${bggreen}${black}${bold}"
echo "Panel installation..."
echo "${reset}"
sleep 1s

/usr/bin/mysql -u root -p$CIPI_DATABASE_PASSWORD <<EOF
CREATE DATABASE IF NOT EXISTS cipi;
EOF
clear
sudo rm -rf /var/www/html
cd /var/www && git clone https://github.com/$CIPI_GIT_REPOSITORY.git html
cd /var/www/html && git pull
cd /var/www/html && git checkout $CIPI_GIT_BRANCH
cd /var/www/html && git pull
sudo chmod -R o+w /var/www/html/storage
sudo chmod -R 775 /var/www/html/storage
sudo chmod -R o+w /var/www/html/bootstrap/cache
sudo chmod -R 775 /var/www/html/bootstrap/cache
sudo chown -R www-data:cipi /var/www/html
sudo chmod -R 775 /var/www/html
CIPISETUP=/var/www/temp.sh
sudo touch $CIPI_PANEL_SETUP
sudo cat > $CIPI_PANEL_SETUP <<EOF
cd /var/www/html && unlink .env
cd /var/www/html && cp .env.example .env
cd /var/www/html && composer install --no-interaction
cd /var/www/html && php artisan key:generate
rpl -i -w "APP_ENV=local" "APP_ENV=production" /var/www/html/.env
rpl -i -w "APP_URL=http://localhost" "APP_URL=http://$CIPI_SERVER_IP" /var/www/html/.env
rpl -i -w "CIPI_SSH_SERVER_HOST=" "CIPI_SSH_SERVER_HOST=$CIPI_SERVER_IP" /var/www/html/.env
rpl -i -w "CIPI_SSH_SERVER_PASS=" "CIPI_SSH_SERVER_PASS=$CIPI_USER_PASSWORD" /var/www/html/.env
rpl -i -w "CIPI_SQL_DBROOT_PASS=" "CIPI_SQL_DBROOT_PASS=$CIPI_DATABASE_PASSOWORD" /var/www/html/.env
cd /var/www/html && php artisan storage:link
cd /var/www/html && php artisan view:cache
cd /var/www/html && php artisan config:cache
cd /var/www/html && php artisan route:cache
cd /var/www/html && php artisan migrate --seed --force
EOF
su -c "sh $CIPI_PANEL_SETUP" cipi
sudo unlink $CIPI_PANEL_SETUP
sudo chown -R www-data:cipi /var/www/html
sudo chmod -R 775 /var/www/html



# FINE TUNING
clear
echo "${bggreen}${black}${bold}"
echo "Fine tuning..."
echo "${reset}"
sleep 1s

sudo chown www-data:cipi -R /var/www/html
sudo chmod -R 750 /var/www/html
sudo echo 'DefaultStartLimitIntervalSec=1s' >> /usr/lib/systemd/system/user@.service
sudo echo 'DefaultStartLimitBurst=50' >> /usr/lib/systemd/system/user@.service
sudo echo 'StartLimitBurst=0' >> /usr/lib/systemd/system/user@.service
sudo systemctl daemon-reload

TASK=/etc/cron.d/cipi.crontab
touch $TASK
cat > "$TASK" <<EOF
0 6 * * 0 certbot renew -n -q --pre-hook "service nginx stop" --post-hook "service nginx start"
0 4 * * 4 certbot renew --nginx --non-interactive --post-hook "systemctl restart nginx.service"
20 4 * * 7 apt-get -y update
40 4 * * 7 DEBIAN_FRONTEND=noninteractive DEBIAN_PRIORITY=critical sudo apt-get -q -y -o "Dpkg::Options::=--force-confdef" -o "Dpkg::Options::=--force-confold" dist-upgrade
20 5 * * 7 apt-get clean && apt-get autoclean
50 5 * * * echo 3 > /proc/sys/vm/drop_caches && swapoff -a && swapon -a
* * * * * cd /var/www/html && php artisan schedule:run >> /dev/null 2>&1
5 2 * * * cd /var/www/html/utility/cipi-update && sh run.sh >> /dev/null 2>&1
EOF
crontab $TASK
sudo systemctl restart nginx.service
sudo rpl -i -w "#PasswordAuthentication" "PasswordAuthentication" /etc/ssh/sshd_config
sudo rpl -i -w "# PasswordAuthentication" "PasswordAuthentication" /etc/ssh/sshd_config
sudo rpl -i -w "PasswordAuthentication no" "PasswordAuthentication yes" /etc/ssh/sshd_config
sudo rpl -i -w "PermitRootLogin yes" "PermitRootLogin no" /etc/ssh/sshd_config
sudo service sshd restart
TASK=/etc/supervisor/conf.d/cipi.conf
touch $TASK
cat > "$TASK" <<EOF
[program:cipi-worker]
process_name=%(program_name)s_%(process_num)02d
command=php /var/www/html/artisan queue:work --sleep=3 --tries=3 --max-time=3600
autostart=true
autorestart=true
stopasgroup=true
killasgroup=true
user=cipi
numprocs=8
redirect_stderr=true
stdout_logfile=/var/www/worker.log
stopwaitsecs=3600
EOF
sudo supervisorctl reread
sudo supervisorctl update
sudo supervisorctl start all
sudo service supervisor restart



# COMPLETE
clear
echo "${bggreen}${black}${bold}"
echo "Cipi installation has been completed..."
echo "${reset}"
sleep 1s



# SETUP COMPLETE MESSAGE
clear
echo "***********************************************************"
echo "                    SETUP COMPLETE "
echo "***********************************************************"
echo ""
echo " SSH root user: cipi"
echo " SSH root pass: $CIPI_USER_PASSWORD"
echo " MySQL root user: cipi"
echo " MySQL root pass: $CIPI_DATABASE_PASSOWORD"
echo ""
echo " To manage your server visit: http://$CIPI_SERVER_IP/login"
echo " Default credentials are: panel@cipi.sh / Change-Me"
echo ""
echo "***********************************************************"
echo "          DO NOT LOSE AND KEEP SAFE THIS DATA"
echo "***********************************************************"