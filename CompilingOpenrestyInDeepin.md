#### Compiling OpenResty in Deepin

* Creating admin and group of nginx:

  ```bash
  > sudo groupadd nginx
  > sudo useradd nginx -g nginx -s /sbin/nologin -M
  ```

* Downloading package of openresty:

  ```bash
  # Downloading openresty package
  wget https://openresty.org/download/openresty-1.15.8.1.tar.gz
  # Unpacking
  tar -zxf openresty-1.15.8.1.tar.gz
  ```

* Building configure file, compiling and installing:

  ```bash
  cd openresty-1.15.8.1
  ./configure --prefix=/usr/local/openresty --group=nginx --user=nginx
  # compiling and installing
  sudo make && sudo make install
  ```

* Updating nginx.conf:

  ```bash
  sudo vim /usr/local/openresty/nginx/conf/nginx.conf
  #user nobody => user nginx nginx
  ```

* Setting nginx.service

  ```bash
  sudo cp nginx.service /lib/systemd/system/
  # Starting nginx
  sudo systemctl start nginx
  # Booting from boot
  sudo systemctl enable nginx
  ```

  nginx.service

  ```
  [Unit]
  Description=The NGINX HTTP and reverse proxy server
  After=syslog.target network.target remote-fs.target nss-lookup.target
  
  [Service]
  Type=forking
  PIDFile=/usr/local/openresty/nginx/logs/nginx.pid
  ExecStartPre=/usr/local/openresty/nginx/sbin/nginx -t
  ExecStart=/usr/local/openresty/nginx/sbin/nginx
  ExecReload=/usr/local/openresty/nginx/sbin/nginx -s reload
  ExecStop=/bin/kill -s QUIT $MAINPID
  PrivateTmp=true
  
  [Install]
  WantedBy=multi-user.target
  ```

*So easy, mom doesn't have to worry about my study anymore.*