## YAF填"坑"历程

*坑不坑, 自己用了就知道, 像我这种技术渣渣, 不管多好的框架, 用起来总是坎坷的.*

先把官方链接放出来, 点击[YAF](http://www.laruence.com/manual/)可快速跳转至官方手册, 其他参考的链接就放在下面, 开始小白的填坑之旅.

哦, 对了, 对应代码仓库地址: [https://github.com/speauty/YAFPitProject](https://github.com/speauty/YAFPitProject)

* #### 安装YAF框架
  1 下载安装包, 并解压
  ```shell script
  > wget http://pecl.php.net/get/yaf-3.0.9.tgz
  > tar -zxf yaf-3.0.9.tgz
   ```
  2 编译安装YAF
  ```shell script
  > cd yaf-3.0.9
  > /usr/local/php/phpize
  > ./configure --with-php-config=/usr/local/php/bin/php-config
  > sudo make && sudo make install
  ```
  3 在`php.ini`配置YAF扩展
  ```shell script
  > sudo vim /usr/local/php/lib/php.ini
  > # 加上extension=yaf, 然后保存退出即可
  ```
  4 检测YAF扩展是否配置
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
  5 到这里, YAF也算安装完毕, 其中配置项的注释源于YAF文档

* #### 按文档尝试
   1 先来梳理项目结构
   ```shell script
   + public
     |- index.php //入口文件
     |- .htaccess //重写规则    
     |+ css
     |+ img
     |+ js
   + conf
     |- application.ini //配置文件   
   + application
     |+ controllers
        |- Index.php //默认控制器
     |+ views    
        |+ index   //控制器
           |- index.phtml //默认视图
     |+ modules //其他模块
     |+ library //本地类库
     |+ models  //model目录
     |+ plugins //插件目录
  
  # 是不是很是眼熟? 没错, 就是官网拷贝过来的, 和原生写法组织目录差不多, 不过这里把类库和插件都在放在应用那层目录下, 要我说, 又得单独提到根目录, 估计也是受TP框架的影响.
   ```
  2 配置nginx虚拟站点
  ```shell script
  server {
    listen 88;
    # root该使用绝对路径
    root   ~/GitSelf/YAFPitProject/public;
    index  index.php index.html index.htm;
    include php73.conf;
    if (!-e $request_filename) {
      rewrite ^/(.*)  /index.php/$1 last;
    }
    access_log  /var/log/wwwlogs/local.yaf.com.log;
    error_log  /var/log/wwwlogs/local.yaf.com.error.log;
  }
  ```
  3 最后小结一下
    * 默认是index模块, 访问地址http://127.0.0.1:88/模块(index模块可省略)/控制器/方法名
    
* #### 关于Bootstrap(以下简称启动器)

   这是个很奇怪的问题, 如何使用启动器, 首先要去配置启动器, 这跟YAF的应用启动有莫大关系, 刚开始我是这样启动的 `$app->run()`, 顾名思义, 启动这个应用, 那么启动器呢? 显然是没有被调用, 要显式调用 `$app->bootstrap()->run()`.
   
   照这样看来, 可以在启动器中配置一些初始化数据, 比如引入composer包, 比如注册本地类库, 比如注册配置数据, 等等. 总之, 就是一个初始化操作. 功能差不多就这些, 还有启动器位置, 默认是在应用目录下的继承Yaf_Bootstrap_Abstract的一个Bootstrap类, 这只是默认情况, 也可以通过配置文件自定义. 不知道有没有注意到, 在应用实例化的时候, 传入了一个配置文件, 也就是说,在这个配置文件中, 我们可以变更一个默认的配置, 其中正好有, 启动器的路径配置 `application.bootstrap`, 我这里就是通过这个配置设置的一个启动器`application.bootstrap=APP_PATH "/bootstrap/AppBootstrap.php"`. 哦,对了, 根据官网所言: `所有在Bootstrap类中定义的, 以_init开头的方法, 都会被依次调用, 而这些方法都可以接受一个Yaf_Dispatcher实例作为参数`, 请注意依次调用的特性哦. 仓库代码那边也有相应的注释, 虽然有些繁复, 不过看心情的事情.

* #### 关于自动加载器
   
   在自启动时, YAF会通过SPL注册一个自己的Autoloader, 对于MVC类, 根据配置的路径进行加载, 而且只会尝试一次. 对于非MVC类来说, 也要区分全局类和本地类, 这里主要说下本地类, 就是在配置中指定目录下的类 `application.library`, 并且我这里也开始了目录小写的配置`yaf.lowcase_path => On => On`, 主要也是为了统一. 不过就算这样配置了也不算, 还要特意注册本地类前缀, 通过调用Yaf_Loader的registerLocalNamespace来实现, 位置是在启动器中. 不过我刚测试一下, 不注册好像也是可以的. 主要刚在翻看文档时, 有这么一句: **Yaf规定类名中必须包含路径信息, 也就是以下划线"_"分割的目录信息. Yaf将依照类名中的目录信息, 完成自动加载**, 在本地类使用时候, 记住这么一条规则好像就可以了. 我之前在这里犯迷糊, 是因为Controller关键字的误导.

* #### 关于ErrorController和ErrorAction
   首先打开两个配置`throwException`和`catchException`, 配置好之后, 便可以捕获异常, 把对应的ErrorController作为最终处理, 可在那里写日志之类的处理.

* #### 关于Plugin(插件)
   这可是个好东西, Hook, 之前用其他框架, 也有所体会, 比如什么前置后置操作等, 不过YAF提供的Hook好像要多那么几个, 主要表现在分发那块. 刚又去测试了一下, 把插件放在根目录下, 结果加载失败, 在不用require/include的情况下, 所以还是还原到应用目录下去. 插件的命名和控制器是有对应关系的, 在访问控制器时, 回去查找有没有对应的插件, 而且还是不分模块的那种. 不过可以在插件里面做细化处理, 比如通过获取当前访问的模块/控制器/方法来区分处理.
   
   刚在翻看文档时, 注意到插件部署的两种方式, 一个呢, 就是放在默认的目录下. 还有个就是放在类库目录下, 由普通加载规格加载, 不过需要注意的是, 后缀不能用Plugin, 否则会到插件默认目录去查找, 自然是查找失败的.
* #### 关于Route(路由)
   这个东西说简单也简单, 说难也还是有那么一点难度的, 不过就使用上来, 还是没多大问题. 只不过我原先理解有误, 折腾了大半天才把`addConfig`配置出来, 为了这个, 甚至还去翻了下框架源码, 虽然看的是两眼懵逼. 可也抵挡不了我装逼的决心, 之后经历了疯狂的百度, 查看各种issue, 繁复翻看文档, 最终还不是给我出来了, wo...并且呢, 我还想自定义个路由协议, 主要是因为YAF自带的路由, 似乎并不支持请求方式的检测, 这就导致了, 我需要单独做检测, 想起来就有些不情愿. 不过呢, 没有找到相关的例子, 索性放弃了. 先把代码贴出来吧:
   
   ```shell script
   $router = $dispatcher->getRouter();
   $routeArr = new YafConfigIni(ROOT_PATH.'/route/route.ini');
   $router->addConfig($routeArr->get('main')->toArray());
  
   [main]
   main.type="rewrite"
   main.match="/"
   main.route.module=index
   main.route.controller=index
   main.route.action=index
   ```
   看出来什么没有? 这就是main路由, 通过/可匹配到, 对了, 这就是rewrite路由. 我主要就是想用这个, 自定义路由映射, 就和取个别名差不多. 主要之前用其他框架, 也是这种比较多. 还有就是, 暂时不清楚怎么取消默认的静态路由. 关于普通路由, 正则路由等其他类型的路由, 就只有单独去看文档. 这些都比较简单. 我现在关于路由比较想知道C层是怎么实现的, 还有自定义路由协议的写法.

* ##### 参考链接
   * [YAF框架入门教程](https://www.jianshu.com/p/1460d2296f19)
   * [如果使自己的文件也使用namespace](https://github.com/laruence/yaf/issues/159)
   * [phpstorm配置yaf提示](https://segmentfault.com/q/1010000003851803)