### Docker FAQ

*Created By Speauty at 2020.01.09*

这是在使用Docker时遇到的一些问题(其中也有朋友问的), 结合相应解决方案, 记录于此, 方便再次遇到时, 查看并加深印象. 还有就是操作环境, 如果没有特殊说明, 统一默认为`ENV-01`.

#### ENV-01
*默认实践环境*
* uname -a
```
Linux speauty-pc 5.3.0-26-generic 
#28~18.04.1-Ubuntu SMP Wed Dec 18 16:40:14 UTC 2019 
x86_64 x86_64 x86_64 
GNU/Linux
```
* cat /proc/version
```
Linux version 5.3.0-26-generic (buildd@lgw01-amd64-039) 
(gcc version 7.4.0 (Ubuntu 7.4.0-1ubuntu1~18.04.1)) 
#28~18.04.1-Ubuntu SMP Wed Dec 18 16:40:14 UTC 2019
```

#### FAQ-01: 开机时, 怎么实现容器自启动?
这是比较基础的问题, `docker run`可携带许多参数, 其中有一项便是`--restart=always`, 这是在Docker启动时, 带有该参数的容器也会随之启动.

当然容器已经存在, 总不至于删除重新创建吧? 这里需要注意有`docker update`, 可配合使用, 比如`docker update --restart=always <CONTAINER ID>`, 就可配置对应容器的`--restart`参数. 说了这么多, 那么该参数只有这一个值吗? 显然不是. 

经过查阅得知, 有三个可选值, 分别是:
* no:  容器存在时, 不自动重启该容器;
* on-failure[:max-retries]: 当容器非0状态退出时才进行重启, 可以配置最大尝试次数;
* always: 只要容器处于退出状态, 就会重启该容器.

还有一点, 也一并说了, Docker自启, 其实这个没什么好说的, `sudo systemctl enable docker.service`就可以了.

*参考链接: https://docs.docker.com/engine/reference/commandline/run/*