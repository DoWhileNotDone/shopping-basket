# Fix permissions after you run commands on both hosts and guest machine
if !Vagrant::Util::Platform.windows?
  system("
      if [ #{ARGV[0]} = 'up' ]; then
          echo 'Setting group write permissions for ./var/*'
          chmod 775 ./var
          chmod 775 ./var/*
          chmod 664 ./var/*/*
      fi
  ")
end

VAGRANTFILE_API_VERSION = "2"

Vagrant.configure(VAGRANTFILE_API_VERSION) do |config|

  config.vm.provider "virtualbox" do |v|
    v.memory = 2048
  end

  config.vm.box = "bento/ubuntu-18.04"
  config.vm.network "private_network", ip: "192.168.50.52"

  # Make sure logs folder is owned by apache with group vagrant
  config.vm.synced_folder "var", "/vagrant/var", owner: "www-data", group: "vagrant"

  # Update apt packages
  config.vm.provision "shell", name: "apt", inline: <<-SHELL
    export DEBIAN_FRONTEND=noninteractive
    apt-get update && apt-get upgrade
    packagelist=(
      libssl1.0-dev
      libreadline-dev
      libyaml-dev
      libxml2-dev
      libxslt1-dev
      libnss3
      libx11-dev
      software-properties-common
      wget
      unzip
      curl
      ant
    )
    apt-get install -y ${packagelist[@]}
  SHELL

  config.vm.provision "shell", name: "add postgres repo", inline: <<-SHELL
    PG_REPO_APT_SOURCE=/etc/apt/sources.list.d/pgdg.list
    if [ ! -f "$PG_REPO_APT_SOURCE" ]
    then
      # Add PG apt repo:
      echo "deb http://apt.postgresql.org/pub/repos/apt/ bionic-pgdg main" > "$PG_REPO_APT_SOURCE"

      # Add PGDG repo key:
      wget --quiet -O - https://apt.postgresql.org/pub/repos/apt/ACCC4CF8.asc | apt-key add -

      apt-get update
    fi

  SHELL

  config.vm.provision "shell", name: "install apache", inline: <<-'SHELL'
    apt-get install -y apache2
    #Allow port 80 through the firewall
    ufw allow 'Apache'
  SHELL

  config.vm.provision "shell", name: "install php", inline: <<-SHELL

    add-apt-repository ppa:ondrej/php
    apt update

    # PHP and modules
    # Not all these packages may be required, it is just a list of the most common
    phppackagelist=(
      php-pear
      php7.3-dev
      php7.3-zip
      php7.3-curl
      php7.3-xml
      php7.3-xmlrpc
      php7.3-xmlwriter
      php7.3-mbstring
      php7.3-pgsql
      php7.3-sqlite
      php7.3-pdo
      php7.3-gd
      php7.3-intl
      php7.3-xsl
      php7.3-xdebug
      libapache2-mod-php
   )

   apt-get install -y php7.3
   apt-get install -y ${phppackagelist[@]}
  SHELL

  # Install Composer (Globally)
  config.vm.provision "shell", name: "install composer", privileged: false, inline: <<-SHELL
     cd /vagrant && curl -sS https://getcomposer.org/installer | php
     sudo mv composer.phar /usr/local/bin/composer
     sudo chmod 775 /usr/local/bin/composer
  SHELL

  config.vm.provision "shell", name: "install postgres", inline: <<-SHELL

    # Postgres 12 and modules
    # Not all these packages may be required, it is just a list of the most common
    pgpackagelist=(
      postgresql
      libpq5
      postgresql-12
      postgresql-client-12
      postgresql-client-common
      postgresql-contrib
    )

    apt-get install -y   ${pgpackagelist[@]}

  SHELL

  #Update Apache config and restart
  config.vm.provision "shell", name: "configure apache", inline: <<-'SHELL'
    # No Document root/public - uses php -S
    sed -i -e "s/AllowOverride None/AllowOverride All/" /etc/apache2/apache2.conf

    a2enmod rewrite
    apachectl restart
    # Make sure Apache also runs after vagrant reload
    systemctl enable apache2
  SHELL

  # Update Apache config and restart
  config.vm.provision "shell", name: "configure apache", inline: <<-'SHELL'

    # Symlink DocumentRoot o \Vagrant\Public
    ln -s /vagrant/public /var/www/html/service

    sed -i -e "s/DocumentRoot \/var\/www\/html/DocumentRoot \/var\/www\/html\/service/" /etc/apache2/sites-enabled/000-default.conf
    sed -i -e "s/AllowOverride None/AllowOverride All/" /etc/apache2/apache2.conf

    a2enmod rewrite
    apachectl restart
    # Make sure Apache also runs after vagrant reload
    systemctl enable apache2
  SHELL


  config.vm.provision "shell", name: "configure postgres", inline: <<-SHELL
    sed -i '/# IPv4 local connections:/ a host    all             postgres        samehost                trust' /etc/postgresql/12/main/pg_hba.conf
    sed -i -e 's/local   all             postgres                                peer/local   all             postgres                                trust/' /etc/postgresql/12/main/pg_hba.conf
    service postgresql restart
    # Make sure Postgres also runs after vagrant reload
    systemctl enable postgresql
  SHELL

  # Run Ant build for provisioning development
  config.vm.provision "shell", name: "run ant build script development target", privileged: false, inline: <<-'SHELL'
    cd /vagrant && cp .env-development .env
    cd /vagrant && ant development
  SHELL

  config.vm.post_up_message = <<MESSAGE

   You are now up and running.

   The URL is 192.168.50.52/

MESSAGE

end
