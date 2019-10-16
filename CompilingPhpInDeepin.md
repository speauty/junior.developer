#### Compiling php in deepin
*This is a article about compiling php in deepin.*
##### Environments
* System: Linux speauty-PC 4.15.0-30deepin-generic #31 SMP Fri Nov 30 04:29:02 UTC 2018 x86_64 GNU/Linux

##### Compiling Php
1. Downloading package of php:
   - to execute the command: `wget https://www.php.net/distributions/php-7.3.10.tar.bz2`.
2. Unpacking the package downloaded:
   - to execute the command: `tar -jxf php-7.3.10.tar.bz2`.
3. Setting the configurations of php:
   - to execute the command: `./configure --prefix=/usr/local/php --enable-fpm --with-fpm-group=php-fpm --with-fpm-user=php-fpm --with-openssl --with-mysqli=mysqlnd --with-pdo-mysql=mysqlnd --with-bz2 --enable-exif --with-mhash --enable-mbstring --enable-sockets`;
   - breaking:`configure: error: Cannot find OpenSSL's <evp.h>`;
      - to install libssh-dev: `sudo apt install libssh-dev`;
   - breaking: `configure: error: Please reinstall the BZip2 distribution`;
      - to install bzip2: `sudo apt install libbz2-dev`;
   - if you see 'Thank you for using PHP.', it means ok.
4. Making and install:
   - to execute command for compiling: `sudo make`;
   - if you see 'Build complete.', please next;
   - to execute command for installing: `sudo make install`;
   - after installing, you can input `/usr/local/php/bin/php -v` to test.
5. Setting the environment variable:
   - to do follow with me: `sudo echo 'export PATH=$PATH:/usr/local/php/bin' >> /etc/profile`, but break with `bash: /etc/profile: 权限不够`;
   - so use vim to edit this file, `sudo vim /etc/profile`, entering `Shift+g`, and `o`, then input `export PATH=$PATH:/usr/local/php/bin`;
   - reboot next.
   - and after reboot, input `php -v`, you can see 'PHP 7.3.10 (cli)...', it's ok.
6. Setting auto start:
   - to create a php-fpm script reference to [link](https://www.cnblogs.com/tongl/p/7217283.html);
   - to add `sudo update-rc.d php-fpm73 defaults`, but warning `insserv: warning: script 'php-fpm73' missing LSB tags and overrides`;
   - so we can install chkconfig;
   - but fail half of hour trying. I try `systemctl`;
   - to clone a php-fpm.service file, then moving to /usr/lib/systemd/system/php-fpm73.service;
   - to execute the command: `sudo chmod +x php-fpm73.service`;
   - but it's fail too, so this config should do later.
7. Checking php-fpm
   - to start php-fpm with the command: `/usr/local/php/sbin/php-fpm --nodaemonize --fpm-config /usr/local/php/etc/php-fpm.conf`;
   - some notices:
      - `NOTICE: [pool www] 'user' directive is ignored when FPM is not running as root`;
      - `NOTICE: [pool www] 'group' directive is ignored when FPM is not running as root`;
   - now, we can create a user and group named php_fpm, or other;
   - `sudo groupadd php-fpm`;
   - `sudo useradd php-fpm -g php-fpm -s /sbin/nologin -M`;
   - and then, to change config file php-fpm;
   ```
     user=php-fpm
     group=php-fpm
     listen=/usr/local/php/var/run/php-fpm73.sock
     listen.owner=php-fpm
     listen.group=php-fpm
     listen.mode=0666
   ```
   - if php-fpm73.sock not found, please create by yourself, and chmod to 666;
   - surprising!!! it's working now, `systemctl`, maybe the config not right before.

##### About compiling php, there has no more things to show, I will install extends tomorrow if free.

##### Annexes
* php-fpm73.service:
```
[Unit]
Description=The PHP FastCGI Process Manager 
After=syslog.target network.target

[Service] 
Type=simple
PIDFile=/usr/local/php/var/run/php-fpm.pid 
ExecStart=/usr/local/php/sbin/php-fpm --nodaemonize --fpm-config /usr/local/php/etc/php-fpm.conf 
ExecReload=/bin/kill -USR2 $MAINPID
ExecStop=/bin/kill -SIGINT $MAINPID
PrivateTmp=true

[Install] 
WantedBy=multi-user.target
```