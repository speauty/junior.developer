老规矩, 检测一下系统: 
```bash
> uname -a
> Linux speauty-PC 4.15.0-30deepin-generic #31 SMP Fri Nov 30 04:29:02 UTC 2018 x86_64 GNU/Linux
> cat /etc/debian_version
> 9.0
```
![查看版本截图.png](https://upload-images.jianshu.io/upload_images/8802208-64098274e6fb36c9.png?imageMogr2/auto-orient/strip%7CimageView2/2/w/500)

直接使用apt安装git, 听说这个东东具有超级牛力:
```bash
> sudo apt install git
> ...
> git --version
> git version 2.11.0
```
![apt安装git过程图.png](https://upload-images.jianshu.io/upload_images/8802208-9de4c071fe1463c4.png?imageMogr2/auto-orient/strip%7CimageView2/2/w/500)

生成秘钥和公钥, 由于我之前已经设置过, 所以有个 `overwrite` 的提示:
![生成秘钥公钥对.png](https://upload-images.jianshu.io/upload_images/8802208-c6fdc7df50a99e90.png?imageMogr2/auto-orient/strip%7CimageView2/2/w/500)

很是折腾啊, 刚整了有半个小时吧, 之前也没遇到这种事:

![权限被拒.png](https://upload-images.jianshu.io/upload_images/8802208-f1beb725aa4c69a0.png?imageMogr2/auto-orient/strip%7CimageView2/2/w/500)

![跟踪1.png](https://upload-images.jianshu.io/upload_images/8802208-753cb015c4bd3c1c.png?imageMogr2/auto-orient/strip%7CimageView2/2/w/500)

![跟踪2.png](https://upload-images.jianshu.io/upload_images/8802208-2d89ff5349b8295b.png?imageMogr2/auto-orient/strip%7CimageView2/2/w/500)

由于跟踪有点长, 只好分成了两张, 其中重新生成了秘钥很多, 甚至采用过dsa格式, 不过github那边似乎不支持. 导致该问题的主要原因是未将自定义名称的秘钥加入ssh中, 检索失败. 可使用ssh-add 秘钥地址 `ssh-add ~/.ssh/id_rsa`, 然后使用 `ssh-add -l` 查看秘钥列表.

![秘钥列表.png](https://upload-images.jianshu.io/upload_images/8802208-786e621065bb3d26.png?imageMogr2/auto-orient/strip%7CimageView2/2/w/500)

经过上面处理后, 就可以测试通了:

![SSH测试.png](https://upload-images.jianshu.io/upload_images/8802208-edd5968f2c1113e5.png?imageMogr2/auto-orient/strip%7CimageView2/2/w/500)

是不是还忘了什么?  是了, 在github上添加公钥, 将后缀为pub文件的内容复制过去即可:

![添加公钥.png](https://upload-images.jianshu.io/upload_images/8802208-7072090f3b199bc9.png?imageMogr2/auto-orient/strip%7CimageView2/2/w/500)

还有git的配置, 其实大多也就是配个名称和邮箱:

![config.png](https://upload-images.jianshu.io/upload_images/8802208-77b169009ddf0726.png?imageMogr2/auto-orient/strip%7CimageView2/2/w/500)




