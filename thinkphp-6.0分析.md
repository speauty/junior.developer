### thinkphp-6.0版本分析



* #### 安装
```bash
> cd /usr/local/wwwroot/thinkphp
> composer create-project topthink/think=6.0.x-dev 6.0
> # 开启内置服务器
> cd 6.0/
> php think run
> # 接下来, 就可以进行AB压测
> # 可能是机子原因, QPS才1.74, 低的有些恐怖
```

* #### 入口文件启动相关

翻代码才注意到, thinkphp的核心库似乎在vendor目录下, 这个才是php框架的业界标准, 尝试过的hypref以及easyswoole的核心都是由composer管理. 不过依然没变的是把public做为开放的唯一入口, 当然, 这也是可以调整的, 为了安全着想, 还是不要去改动.

我们来看看入口文件, 和之前似乎不大一样
```php
// [ 应用入口文件 ]
// 放在 think 命名空间下, 这点似乎没变
namespace think;
// 加载composer包
require __DIR__ . '/../vendor/autoload.php';

// 执行HTTP应用并响应
// 这里需要跟踪下
// public/index.php => think/App => think/Http
// 明确一下(new Class())->property, 据此可知, http应该是think/App的属性之一.
// 在think/App中一来, 就申明了严格模式declare (strict_types = 1);(过后解释)
// think/App继承于think/Container;
// 在Container可以 容器管理类 支持PSR-11,这是一个容器, 那么App也可以说是一个容器.
// 明确来说, 应该是应用容器.
// 在App中有个容器绑定标识的属性$bind, 是个数组, 可以看到之中包含了很多类, 其中就有
// 'http' => Http:Class一项,看起架构方法, 可以传个根目录参数
// 在架构方法中, 设置了一些属性, 主要包括: think路径, 项目根路径, 应用目录路径,运行临时目录
// 然后就是检测应用目录下的provider文件是否存在, 切到provider看下
// provider返回的是可以自定义加入容器的类标识的一个数组
// 再切到Container的bind方法看看, 可以接受两个参数, 一个是类标志$abstract, 一个是类或闭包或实例$concrete,
// 先判断$abstract是否为数组, 如果是话, 直接循环调用自己, 是个狠人.
// 不管怎么说, 进入下一步的判断必须类标志不是数组, 那么就是字符串?
// 判断$concrete的类型
// 如果是闭包, 就直接加到了bind属性
// 如果是其他, 那就是类或实例嘛,那就获取真实类名?
// 就是Container的getAlias方法
// 先判断是否已经有绑定的对应类标志, 然后取出对应实例, 如果是字符串的话,
// 继续取?取到不是字符串?那不是意味着, 我们可以取多级别名
// 比如 a=>b=>c=>d=>实例, 如果最终实例是a的话, 不知道会不会出现死循环的情况
// 先不多说, 回到上面, 获取了真实别名后
// 就直接把类或实例绑在上面就行了, 返回到think/App的架构函数
// 在判断完 provider后, 调用了Container的setInstance设置单例方法?
// 直接将当前think/App传进去, 作为容器对象实例, 这个不就是工厂模式?
// 尽量降低继承者对被继承者的耦合度
// 然后又将think/App绑定到$bind的app键上?
// 也把Container容器绑进来?
// 常规的似乎分析完了, 那么问题来了, http属性没有直接设置,
// 调用的时候为什么不报错呢?
$http = (new App())->http;

$response = $http->run();

$response->send();

$http->end($response);
```