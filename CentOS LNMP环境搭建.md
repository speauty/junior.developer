## CentOS LNMP环境搭建[20190905]

### 准备工作
- #### 使用 uname 查看系统类型
```
> uname -a
> Linux iZwz9cp0g6fn65ijpiqm1yZ 3.10.0-957.21.3.el7.x86_64 #1 SMP Tue Jun 18 16:35:19 UTC 2019 x86_64 x86_64 x86_64 GNU/Linux
```
- #### 切换阿里云源
```
> # 备份旧的云源
> sudo mv /etc/yum.repos.d/CentOS-Base.repo /etc/yum.repos.d/CentOS-Base.repo.backup
> # 下载阿里云源
> sudo wget -O /etc/yum.repos.d/CentOS-Base.repo http://mirrors.aliyun.com/repo/Centos-7.repo
> # 生成缓存
> yum makecache
```
- #### 安装一些类库
```
> sudo yum install pcre-devel openssl-devel gcc curl libaio m4 autoconf libxml2 libxml2-devel bzip2 bzip2-devel bzip2  glibc-headers gcc-c++ 
```
- #### 创建网站运行用户及组
```
> # 创建 nginx 执行用户及分组
> sudo groupadd nginx
> sudo useradd nginx -g nginx -s /sbin/nologin -M
> # 创建 php-fpm 执行用户及分组
> sudo groupadd php-fpm
> sudo useradd php-fpm -g php-fpm -s /sbin/nologin -M
> # 创建 mysql 执行用户及分组
> groupadd mysql
> useradd mysql -g mysql -s /sbin/nologin -M
```
### 编译安装 [OPENRESTY](https://openresty.org/download/openresty-1.15.8.1.tar.gz)
1. 下载安装包文件
```
> # 下载 openresty 安装包文件
> wget https://openresty.org/download/openresty-1.15.8.1.tar.gz
> # 解压到当前目录
> tar -zxf openresty-1.15.8.1.tar.gz
```
2. 配置、编译和安装
```
> cd openresty-1.15.8.1
> # 生成配置
> ./configure --prefix=/usr/local/openresty --group=nginx --user=nginx
> # 编译和安装
> sudo gmake && gmake install
> gmake: *** [install] Error 1
> # 权限不足导致, 前面加上sudo后执行
```
3. 更改NGINX配置项
```
> # 将 #user nobody 改为 user nginx nginx && 去掉 pid 前的注释
> sudo vim /usr/local/openresty/nginx/conf/nginx.conf
```
4. 配置 NGINX 服务
```
> vim nginx.service
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

> # 保存退出, 将文件放到对应目录下
> sudo cp nginx.service /lib/systemd/system/
```
5. 启动NGINX, 并查看状态
```
> # 启动 nginx
> sudo systemctl start nginx
> # 查看nginx状态
> sudo systemctl status nginx
```
6. 其余配置
```
> 启用防火墙
> sudo systemctl start firewalld.service
> # 查看80端口状态
> sudo firewall-cmd --query-port=80/tcp
> # 添加端口并重载防火墙
> sudo firewall-cmd --zone=public --add-port=80/tcp --permanent
> sudo firewall-cmd --reload
> # 设置开机自启动
> sudo systemctl enable nginx
```

### 编译安装 [PHP](https://www.php.net)
1. #### 下载源码包
```
> wget https://www.php.net/distributions/php-7.3.9.tar.bz2
```
2. 解压源码包
```
> tar -jxf php-7.3.9.tar.bz2
> tar (child): bzip2: Cannot exec: No such file or directory
> # 缺少依赖类库
> sudo yum -y install bzip2
```
3. 配置、编译和安装
```
> ./configure --prefix=/usr/local/php --enable-fpm --with-fpm-group=php-fpm --with-fpm-user=php-fpm --with-openssl --with-mysqli=mysqlnd --with-pdo-mysql=mysqlnd --with-bz2 --enable-exif --with-mhash --enable-mbstring --enable-sockets
> configure: error: libxml2 not found. Please check your libxml2 installation.
> # 缺少依赖类库
> sudo yum -y install libxml2 libxml2-devel
configure: error: Please reinstall the BZip2 distribution
> # 缺少依赖类库
> sudo yum -y install bzip2 bzip2-devel
> # 编译和安装
> sudo make && sudo make install
```
4. 拷贝各种配置文件
```
> sudo cp php.ini-development /usr/local/php/lib/php.ini
> sudo cp /usr/local/php/etc/php-fpm.conf.default /usr/local/php/etc/php-fpm.conf
> sudo cp /usr/local/php/etc/php-fpm.d/www.conf.default /usr/local/php/etc/php-fpm.d/www.conf
```
5. 配置 PHP-FPM 服务
```
> vim php-fpm.service
[Unit] 
Description=php-fpm 
After=syslog.target network.target

[Service] 
Type=forking 
PIDFile=/usr/local/php/var/run/php-fpm.pid 
ExecStart=/usr/local/php/sbin/php-fpm 
ExecReload=/bin/kill -USR2 MAINPIDExecStop=/bin/kill−INTMAINPIDExecStop=/bin/kill−INTMAINPID 
PrivateTmp=true

[Install] 
WantedBy=multi-user.target

> sudo cp php-fpm.service /usr/lib/systemd/system
```
6. 其余配置
```
> # 配置环境变量, 在 /etc/profile 文件末尾加上 export PATH=$PATH:/usr/local/php/bin
> sudo vim /etc/profile
export PATH=$PATH:/usr/local/php/bin
> # 重启服务器
> sudo reboot
> # 检测 php
> php -v
> PHP 7.3.9 (cli) (built: Sep  4 2019 14:35:46) ( NTS )
> # 启动 php-fpm
> sudo systemctl start php-fpm &
> # 设置开机自启动
> sudo systemctl enable php-fpm
> # 删除 systemctl 的 php-fpm 配置
> sudo rm -f /usr/lib/systemd/system/php-fpm.service
> # php-fpm.service容易挂掉, 改用service配置
> # 参考链接: https://www.cnblogs.com/tongl/p/7217283.html
> # 安装 composer
> sudo curl -sS https://getcomposer.org/installer | php
> # 将 composer 移到 /usr/local/bin
> sudo mv composer.phar /usr/local/bin/composer
> # 修改镜像
> composer config -g repo.packagist composer https://packagist.phpcomposer.com
```
7. 安装扩展
```
> # 安装 swoole 扩展
> wget https://github.com/swoole/swoole-src/archive/v4.4.1.tar.gz
> tar -zxf v4.4.1.tar.gz
> cd swoole-src-4.4.1/
> /usr/local/php/bin/phpize
> Cannot find autoconf. Please check your autoconf installation and the
$PHP_AUTOCONF environment variable. Then, rerun this script.
> # 缺少依赖
> sudo yum -y install m4 autoconf
> # 生成配置
> ./configure --with-php-config=/usr/local/php/bin/php-config
> configure: error: C++ preprocessor "/lib/cpp" fails sanity check
> # 缺少依赖
> sudo yum -y install glibc-headers gcc-c++ 
> # 编译和安装
> sudo make && sudo make install
> # 更新php配置
> # 在 php.ini 中添加
> # extension_dir="/usr/local/php/lib/php/extensions/no-debug-non-zts-20180731/"
> # extension=swoole
> # 安装 redis 扩展
> wget https://github.com/phpredis/phpredis/archive/5.0.2.tar.gz
> mv 5.0.2.tar.gz phpredis-5.0.2.tar.gz
> tar -zxf phpredis-5.0.2.tar.gz
> cd phpredis-5.0.2
> /usr/local/php/bin/phpize
> ./configure --with-php-config=/usr/local/php/bin/php-config
> sudo make && sudo make install
```
### 编译安装 [REDIS](https://redis.io/)
1. 下载并解压 [redis](http://download.redis.io/releases/redis-5.0.5.tar.gz)
```
> sudo wget http://download.redis.io/releases/redis-5.0.5.tar.gz
> tar xvzf redis-stable.tar.gz
> sudo cp -rf redis-5.0.5 /usr/local/redis
```
2. 编译和安装
```
> cd /usr/local/redis
> sudo make && sudo make install
```
3. 安装服务
```
> cd utils
> sudo ./install_server.sh
> # Port           : 6488
> # Config file    : /etc/redis/6488.conf
> # Log file       : /var/log/redis_6488.log
> # Data dir       : /var/lib/redis/6488
> # Executable     : /usr/local/bin/redis-server
> # Cli Executable : /usr/local/bin/redis-cli
```

### 源码安装 [Mysql](https://www.mysql.com/)
1. 下载并解压源码包
```
> wget https://dev.mysql.com/get/Downloads/MySQL-5.7/mysql-5.7.25-linux-glibc2.12-x86_64.tar.gz
> tar -zxf mysql-5.7.25-linux-glibc2.12-x86_64.tar.gz
```
2. 转移文件
```
> sudo mv mysql-5.7.25-linux-glibc2.12-x86_64 /usr/local/mysql
```
3. 修改 mysql 安装目录拥有者
```
> sudo chown -R mysql:mysql ./
```
4. 安装 mysql
```
> sudo bin/mysqld --initialize --user=mysql --basedir=/usr/local/mysql --datadir=/usr/local/mysql/data
> # 下面这句提示需要注意, 里面有 root账户的临时密码, 首次登录需要更新密码
> [Note] A temporary password is generated for root@localhost: !zow!%eaX44=
```
5. 创建 RSA
```
> # 非对称加密
> sudo bin/mysql_ssl_rsa_setup --datadir=/usr/local/mysql/data
```
6. 准备 my.cnf
```
> # 查看 my.cnf 配置文件加载位置顺序
> mysql --help|grep 'my.cnf' 
```
7. 修改mysql.server
```
> sudo cp /usr/local/mysql/support-files/mysql.server  /etc/init.d/mysqld
> # 添加路径 46行
> # basedir=/usr/local/mysql
> # datadir=/usr/local/mysql/data
> # 授权, 否则配置开机自启会失败
> sudo chmod +x /etc/init.d/mysqld
> # 开机自启
> chkconfig --add mysql
```
8. 添加环境变量
```
> sudo vim /etc/profile
> # PATH=/usr/local/mysql/bin:$PATH
> # 重启后生效
```
9. 设置软连接
```
> sudo ln -s /usr/local/mysql/bin/mysql /usr/bin
```
10. 该死的 /tmp/mysql.sock
```
>  Can't connect to local MySQL server through socket '/tmp/mysql.sock' (2)  
> # 几经周折, 改了无数次套接字位置, 和mysql配置, 以及对应套接字所在目录文件权限, 均无效
> # 最终, 配置了 mysql.service 服务, 一启动, 妈耶, 好了
> # 不过已经下班了, 为了记录一下, 耽搁几分钟, 无妨
> cd ~
> vim mysql.serivce
[Unit]
Description=MySQL Server
Documentation=man:mysqld(8)
Documentation=http://dev.mysql.com/doc/refman/en/using-systemd.html
After=network.target
After=syslog.target

[Install]
WantedBy=multi-user.target

[Service]
User=root
Group=root
ExecStart=/usr/local/mysql/bin/mysqld --user=root
LimitNOFILE = 5000
#Restart=on-failure
#RestartPreventExitStatus=1
#PrivateTmp=false

> sudo cp mysql.service /usr/lib/systemd/system
> sudo systemctl start mysql
> # 启动成功后, 我就去改了套接字位置
> sudo vim /usr/local/mysql/etc/my.cnf
> # 将其中的 sock 全部设置为 /tmp/mysql.sock
> # 需要把之前的配置清除, 比如第8步
```
11. 修改临时密码
```
> # 获取临时密码
> grep 'temporary password' /var/log/mysqld.log
> mysql -uroot -p
> Enter password: 输入之前的临时密码
mysql > show datatables;
> ERROR 1820 (HY000): You must reset your password using ALTER USER statement before executing this statement.
mysql > ALTER USER 'root'@'localhost' IDENTIFIED BY 'root123';
> # 刷新权限
mysql > flush privileges;
```
12. 创建用户和授权
```
> # 创建用户
> create user 'username'@'ip addr' identified by 'passwd';
> # 授权
> grant all privileges on dbname.table to 'username'@'ip addr' identified by 'passwd';
> # 刷新权限
> flush privileges;
```

### 后续操作
1. NGINX 和 PHP 的关联
```
> # 添加一个 nginx 转发 php 请求的通用文件
> cd /usr/local/openresty/nginx/conf
> sudo vim php73.conf
location ~ \.php?.*$
{
    # php-fpm.sock 路径
    fastcgi_pass   unix:/usr/local/php/var/run/php73-fpm.sock;
    fastcgi_index  index.php;
    fastcgi_split_path_info  ^((?U).+\.php)(/?.+)$;
    fastcgi_param  SCRIPT_FILENAME  $document_root$fastcgi_script_name;
    fastcgi_param  PATH_INFO  $fastcgi_path_info;
    fastcgi_param  PATH_TRANSLATED  $document_root$fastcgi_path_info;
    include fastcgi.conf;
}
> sudo mkdir vhosts
> # 将 nginx.conf 的 HTTP SERVERS 后面的注释或删掉, 添加一行, 加载 vhosts 中的虚拟站点配置文件 include vhosts/*.conf;
> cd vhosts
> sudo vim default.www.conf
server
{
    listen 80;
    server_name localhost;
    root /usr/local/wwwroot;
    include php73.conf;
    location / {
        include mime.types;
        default_type application/octet-stream;
    }

    access_log  /usr/local/wwwlogs/localhost.log;
    error_log  /usr/local/wwwlogs/localhost.error.log;
}
> # 以上过程处理完之后, 记得重启 nginx
> # 如果遇到 503 错误, 请检测错误日志, 如果有下列提示出现:
> # connect() to unix:/usr/local/php/var/run/php73-fpm.sock failed (13: Permission denied) while connecting to upstream
> # 检测下对应文件权限, 并修改为666
> sudo chmod 666 /usr/local/php/var/run/php73-fpm.sock
> # 访问正常后, 重启 php-fpm, 又出现刚才那种情况, 请修改 php-fpm 的配置
> sudo vim /usr/local/php/etc/php-fpm.d/www.conf
> # 找到一下配置, 并照此修改
> listen.owner = php-fpm
> listen.group = php-fpm
> listen.mode = 0666
> # 修改之后, 重启 php-fpm
```