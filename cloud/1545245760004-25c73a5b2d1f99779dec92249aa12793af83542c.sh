#mise à jour  
apt-get update 

#variable 

db_root_password="online@2017" 

#installation de curl 

apt-get -y install curl 

#installation de curl 

apt-get -y install git 

#installation de php (version 7.2 par défaut) 

apt-get -y install php 

apt-get -y install libapache2-mod-php  

apt-get -y install php-cli  

apt-get -y install php-mysql  

apt-get -y install php-gd  

apt-get -y install php-imagick  

apt-get -y install php-recode  

apt-get -y install php-tidy  

apt-get -y install php-xmlrpc 

apt-get -y install php-zip  

apt-get -y install php-mbstring 

#installation des utilistaires zip et unzip

apt-get -y install zip

apt-get -y install unzip  

#activation du mode récriture 

a2enmod rewrite

sed -i '/<Directory \/var\/www\/>/,/<\/Directory>/ s/AllowOverride None/AllowOverride All/' /etc/apache2/apache2.conf 

systemctl restart apache2 

 

#installation yarn 

curl -sS https://dl.yarnpkg.com/debian/pubkey.gpg | sudo apt-key add - 

echo "deb https://dl.yarnpkg.com/debian/ stable main" | sudo tee /etc/apt/sources.list.d/yarn.list 

apt-get update  

apt-get -y install yarn 

#nodejs et npm

curl -sL https://deb.nodesource.com/setup_11.x | sudo -E bash -

sudo apt-get install -y nodejs

sudo apt-get install -y build-essential