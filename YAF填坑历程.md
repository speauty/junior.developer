## YAF填"坑"历程

*坑不坑, 自己用了就知道, 像我这种技术渣渣, 不管多好的框架, 用起来总是坎坷的.*

先把官方链接放出来, 点击[YAF](http://www.laruence.com/manual/)可快速跳转至官方手册, 其他参考的链接就放在下面, 开始小白的填坑之旅.

* #### 安装YAF框架
  1. 下载安装包, 并解压
  ```shell script
  > wget http://pecl.php.net/get/yaf-3.0.9.tgz
  > tar -zxf yaf-3.0.9.tgz
   ```
  2. 编译安装YAF
  ```shell script
  > cd yaf-3.0.9
  > /usr/local/php/phpize
  > ./configure --with-php-config=/usr/local/php/bin/php-config
  > sudo make && sudo make install
  ```
  3. 在`php.ini`配置YAF扩展
  ```shell script
  > sudo vim /usr/local/php/lib/php.ini
  > # 加上extension=yaf, 然后保存退出即可
  ```
  4. 检测YAF扩展是否配置
  ```shell script
  > php --ri=yaf
  
  yaf

  yaf support => enabled
  Version => 3.0.9
  Supports => http://pecl.php.net/package/yaf
    
  Directive => Local Value => Master Value
  # 全局类库的目录路径
  yaf.library => no value => no value
  yaf.action_prefer => Off => Off
  yaf.lowcase_path => Off => Off
  # 开启的情况下, Yaf在加载不成功的情况下, 会继续让PHP的自动加载函数加载, 从性能考虑, 除非特殊情况, 否则保持这个选项关闭
  yaf.use_spl_autoload => Off => Off
  # forward最大嵌套深度
  yaf.forward_limit => 5 => 5
  # 在处理Controller, Action, Plugin, Model的时候, 类名中关键信息是否是后缀式, 比如UserModel, 而在前缀模式下则是ModelUser
  yaf.name_suffix => On => On
  # 在处理Controller, Action, Plugin, Model的时候, 前缀和名字之间的分隔符, 默认为空, 也就是UserPlugin, 加入设置为"_", 则判断的依据就会变成:"User_Plugin", 这个主要是为了兼容ST已有的命名规范
  yaf.name_separator => no value => no value
  yaf.st_compatible => Off => Off
  # 环境名称, 当用INI作为Yaf的配置文件时, 这个指明了Yaf将要在INI配置中读取的节的名字
  yaf.environ => product => product
  # 开启的情况下, Yaf将会使用命名空间方式注册自己的类, 比如Yaf_Application将会变成Yaf\Application
  yaf.use_namespace => Off => Off 
  ```
  5. 到这里, YAF也算安装完毕, 其中配置项的注释源于YAF文档.


* ##### 参考链接
   1. [YAF框架入门教程](https://www.jianshu.com/p/1460d2296f19)