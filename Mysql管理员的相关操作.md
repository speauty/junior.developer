### MySQL用户的相关操作
简单来说, 用户是一种数据, 不过存储在 `MySQL` 服务器的系统表`mysql.user`中, 主要用于用户登录及相应权限的管理, 举个简单例子, 你无法登录一个在那张表没有的用户信息, 或你使用一个用户的账号密码登录了一个`MySQL`服务器, 但是该用户没有被授予`select`的权限, 你就无法执行相关查询语句. 从基础开始, 就我以往的使用经验来看, 关于用户的操作主要有一下几个: 增删改查,授权和设置密码等
1. 查看
```
> # 查看当前连接的`MySQL`服务器中所有用户的主机和名称
> SELECT host,user FROM mysql.user;
> # 显示指定用户的所有权限
> SHOW GRANTS FROM username
> # 显示当前登录用户的所有权限
> SHOW GRANTS;
```
2. 删除
```
> DROP USER 'username'@'host';
```
3. 增加
```
> CREATE USER 'username'@'host' IDENTIFIED BY 'password';
> # username-用户名
> # host-可登陆的主机IP, 可使用通配符`%`表示不限制登录主机
> # password-用户密码, 可为空, 表示无密码登录
```
4. 设置密码
```
> # 设置指定用户密码
> SET PASSWORD FOR 'username'@'host' = PASSWORD('newpassword');
> # 设置当前登录用户密码
> SET PASSWORD = PASSWORD("newpassword");
> # 数据表更新
> UPADTE user SET password=password('root') FROM mysql.user WHERE user='root';
```
5. 授权
```
> GRANT privileges ON databasename.tablename TO 'username'@'host'
```

