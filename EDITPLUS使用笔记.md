### EDITPLUS 使用笔记 [点击下载epp](https://www.editplus.com/download.html)

>epp5.0 注册码 注册名：Vovan 注册码：3AG46-JJ48E-CEACC-8E6EW-ECUAW(亲测有效)

>epp3.x 生成注册码链接：[传送门](www.98key.com/editplus)

##### &nbsp;&nbsp;&nbsp;&nbsp;1. 关闭自动生成备份文件功能
![关闭自动生成备份文件.png](https://upload-images.jianshu.io/upload_images/8802208-d8dda0a466694f77.png?imageMogr2/auto-orient/strip%7CimageView2/2/w/500)
##### &nbsp;&nbsp;&nbsp;&nbsp;2. php工具箱配置
###### &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;添加php手册([传送门](http://php.net/docs.php))
![添加php手册示意图.png](https://upload-images.jianshu.io/upload_images/8802208-a9a25d690963f379.png?imageMogr2/auto-orient/strip%7CimageView2/2/w/500)
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;详细参数参考：php手册&nbsp;&nbsp;&nbsp;&nbsp;E:\EditPlus\userfiles\php\php_manual_zh.chm
###### &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;php编译
![php编译.png](https://upload-images.jianshu.io/upload_images/8802208-b5c8e0a5cefc1f3d.png?imageMogr2/auto-orient/strip%7CimageView2/2/w/500)
![pattern.png](https://upload-images.jianshu.io/upload_images/8802208-9fff67087bf8a6cd.png?imageMogr2/auto-orient/strip%7CimageView2/2/w/500)
![php编译预览图.png](https://upload-images.jianshu.io/upload_images/8802208-a0a49e46fe1f14f2.png?imageMogr2/auto-orient/strip%7CimageView2/2/w/500)
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;详细参数参考：php编译&nbsp;&nbsp;&nbsp;&nbsp;D:\speauty_web\server\php-7.0\php.exe&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$(FilePath)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;$(FileDir)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;^.+in(.+)on line（[0-9+]
##### &nbsp;&nbsp;&nbsp;&nbsp;2. 启动服务及配置项
###### &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;启动/停止服务
![启动apache服务配置示意图.png](https://upload-images.jianshu.io/upload_images/8802208-bc872cf987f41380.png?imageMogr2/auto-orient/strip%7CimageView2/2/w/500)
![启动mysql服务配置示意图.png](https://upload-images.jianshu.io/upload_images/8802208-268bb0102ed28125.png?imageMogr2/auto-orient/strip%7CimageView2/2/w/500)
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;参考命令：net start\stop apache\mysql[服务名]
###### &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;编辑配置文件
![更新hosts.png](https://upload-images.jianshu.io/upload_images/8802208-6a64f9486af883e3.png?imageMogr2/auto-orient/strip%7CimageView2/2/w/500)

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;参考命令：E:\EditPlus\editplus.exe[使用的编辑器] filePath[文件所在路径]
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;更新hosts：E:\EditPlus\editplus.exe  C:\Windows\System32\drivers\etc\hosts
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;更新httpd.conf：E:\EditPlus\editplus.exe  D:\speauty_web\server\apache\conf\httpd.conf
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;更新httpd-vhosts.conf：E:\EditPlus\editplus.exe  D:\speauty_web\server\apache\conf\extra\httpd-vhosts.conf
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;更新php.ini：E:\EditPlus\editplus.exe  D:\speauty_web\server\php-7.0\php.ini
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;更新my.ini：E:\EditPlus\editplus.exe  D:\speauty_web\server\mysql\my.ini

##### &nbsp;&nbsp;&nbsp;&nbsp;3. MySQL工具箱
###### &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;连接mysql客户端
![连接mysql客户端.png](https://upload-images.jianshu.io/upload_images/8802208-656d684159b0d03f.png?imageMogr2/auto-orient/strip%7CimageView2/2/w/500)
![执行预览图.png](https://upload-images.jianshu.io/upload_images/8802208-4053df82469ff4bd.png?imageMogr2/auto-orient/strip%7CimageView2/2/w/500)

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;参考命令：mysql -uusername -ppassword

###### &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;执行SQL文件
![执行SQL文件.png](https://upload-images.jianshu.io/upload_images/8802208-494dd276d7f1acdf.png?imageMogr2/auto-orient/strip%7CimageView2/2/w/500)


&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;参考命令：mysql -uusername -ppassword<$(FilePath) $(FileDir)

##### &nbsp;&nbsp;&nbsp;&nbsp;4. 错误参考
###### &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;启动apache和mysql服务错误
![错误参考一.png](https://upload-images.jianshu.io/upload_images/8802208-467e4b8f84134638.png?imageMogr2/auto-orient/strip%7CimageView2/2/w/500)
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;错误提示：发生系统错误 5。拒绝访问。
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;错误原因：权限不足
###### &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;连接mysql和执行sql文件报错
![连接mysql和执行sql文件报错
.png](https://upload-images.jianshu.io/upload_images/8802208-411a58fa91c4b09d.png?imageMogr2/auto-orient/strip%7CimageView2/2/w/500)

&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;错误提示：'mysql' 不是内部或外部命令，也不是可运行的程序
或批处理文件。
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;错误原因：未找到mysql执行文件
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;解决方法：将mysql目录下的bin文件夹加入系统环境变量
![定义MySQL系统变量.png](https://upload-images.jianshu.io/upload_images/8802208-c64d18514fe80c3a.png?imageMogr2/auto-orient/strip%7CimageView2/2/w/500)

> 不定期更新。。。

***
* **初稿二零一八年六月六日**
***







