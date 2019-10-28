#### Docker Learning

*在ubuntu 18.04尝试的*

##### 安装 Docker
```bash
> # 安装docker
> sudo apt-get install docker
> sudo apt-get install docker.io

> # 检测docker版本信息
> docker version 
Client:
 Version:           18.09.7
 API version:       1.39
 Go version:        go1.10.4
 Git commit:        2d0083d
 Built:             Fri Aug 16 14:19:38 2019
 OS/Arch:           linux/amd64
 Experimental:      false

Server:
 Engine:
  Version:          18.09.7
  API version:      1.39 (minimum version 1.12)
  Go version:       go1.10.4
  Git commit:       2d0083d
  Built:            Thu Aug 15 15:12:41 2019
  OS/Arch:          linux/amd64
  Experimental:     false
> # 简单查看docker版本号.
> docker -v
Docker version 18.09.7, build 2d0083d

> # 使用systemctl管理docker服务
```
##### 获取镜像
```bash
> # 从Docker Hub镜像源下载镜像
> # registry-注册服务器, 默认使用Docker Hub服务.
> # NAME-镜像名 TAG-镜像标签,默认为latest.
> docker pull [registry]NAME[:TAG]
> # -a, --all-tags=true|false: 是否获取仓库中的所有镜像, 默认false.
> # 比如, 下载centos 7.6.1810版本.
> docker pull centos:7.6.1810
7.6.1810: Pulling from library/centos
ac9208207ada: Pull complete 
Digest: sha256:62d9e1c2daa91166139b51577fe4f4f6b4cc41a3a2c7fc36bd895e2a17a3e4e6
Status: Downloaded newer image for centos:7.6.1810
> 
```
##### 查看镜像信息
```bash
> # 查看已有镜像的信息
> docker images
> # 更多参数, 使用 man docker images查看.

> # 使用docker tag为本地镜像任意添加新的标签, 相当于链接(快捷方式)
> # NEWNAME必须全为小写字母, 否则会报错.
Error parsing reference: "localCentOS:76" is not a valid repository/tag: invalid reference format: repository name must be lowercase
> docker tag NAME:TAG NEWNAME:NEWTAG
> docker tag centos:7.6.1810 local-centos:76
> # 上面那个镜像的镜像ID还是保持一致的, 可以看出docker tag只是添加了一个快捷方式, 并不影响实际文件.

> # 使用inspect查看详细信
> # 使用docker inspect可以获取该镜像的详细信息, 包括制作者/适应架构/各层的数字摘要等.
> docker inspect NAME:TAG
> # 可使用参数-f指定其中一项内容.
> docker inspect local-centos:76 -f {{".Architecture"}}

> # 查看镜像历史
> # 使用history列出各层的创建信息.
> docker history local-centos:76
> # 不过由于过长被自动截断, 可添加--no-trunc显示完整.

> # 搜索镜像
> # 带keyword关键字的镜像
> docker search keyword
> --filter 增加过滤项.
> is-automated=true 仅显示自动创建的镜像, 默认false.
> stars=3 指定仅显示评价为指定星级以上的镜像, 默认0.
> --no-trunc=true 输出信息不截断显示 默认false.
> docker search --filter=is-automated=true --no-trunc=true nginx
> docker search --filter=stars=3 --no-trunc=true nginx
```

##### 删除镜像
```bash
> # 使用标签删除镜像
> docker rmi NAME:TAG
> # 该操作只是删除对应镜像多个标签中的指定标签, 并不影响镜像文件.

> 使用ID删除镜像
> docker rmi ID

> 如果有依赖该镜像创建的容器, 需要先进行删除, 再删除相应镜像, 尽量不要使用-f进行强行删除.
```

##### 创建镜像
```bash
> 基于已有镜像的容器创建
> docker run -it local-centos:76 /bin/bash
> # 先启动一个容器, 做点操作, 然后记住容器ID, 退出即可.
> docker commit -m '提交信息' -a '作者信息' 容器ID NAME:TAG
> # -m 提交信息 -a 作者信息 -p 提交时暂停容器运行.
> docker commit -m 'add a file' -a 'Speauty' 3c4eaad406c4 test:0.1
> sha256:352aafab413b1177cb779d58b88666ac2305a1c6d5bfcc357c8ea8d237b6d26f
> # 创建成功的话, 会返回新镜像的一个Id值.

> 基于本地模板导入
> # 要直接导入一个镜像, 可以使用[OpenVZ](http://openvz.org/Download/templates/precreated)提供的模板来创建, 或者用其他已导出的镜像模板创建.
> cat ubuntu-14.04-x86_64-minimal.tar.gz | docker import - ubuntu:14.04
```

##### 存出和载入镜像
```bash
> # 存出镜像
> docker save -o image.tar NAME:TAG
> docker save -o centos76.tar local-centos:76

> # 导入镜像
> docker load --input image.tar
> docker load < image.tar
> docker load < centos76.tar
> Loaded image: local-centos:76
```

##### 上传镜像
```bash
> docker push NAME:TAG [registry]NAME:TAG
> # 在上传之前, 可以先使用 docker tag 为镜像添加新标签.
> docker tag local-centos:76 hub-user-name/remote-repository-name:tag
> docker push hub-user-name/remote-repository-name:tag
> # 如果没登录, 会提示被拒绝, 使用 docker login 进行登录, 再重新上传, 一般问题都不大.
> # 默认上传到 [hub-docker](https://hub.docker.com/)
```

##### 创建容器
```bash
> # 新建容器
> docker create -it NAME:TAG
> # 使用 docker create新建的容器处于停止状态, 需要使用docker run来进行启动.

> # 启动容器
> docker run 容器ID

> # 新建并启动容器
> docker run local-centos:76 /bin/echo 'hello world'
> # -t 让docker分配一个伪终端(pseduo-tty)并绑定到容器的标准输入上,
> # -i 让容器的标准输入保持打开
> # -d 可在后台运行
> docker run -it local-centos:76 /bin/bash
> # Ctrl+d或输入exit退出容器

> # 停止容器
> docker stop 容器ID
> # docker ps -qa 可看到所有容器的ID.
> # 处于终止态的容器, 可使用docker start 来启动.
> # docker restart 会将一个运行态的容器先终止, 然后再重新启动它.
```

##### 进入容器
```bash
> # attach进入
> docker attach CONTAINER-ID
> # --detach-keys=[] 指定退出attach,模式的快捷键序列, 默认时Ctrl+p Ctrl+q.
> # --no-stdin=true|false 是否关闭标准输入, 默认是保持打开.
> # --sig-proxy=true|false 是否代理收到系统信号给应用程序, 默认为true.
> # 当多个窗口同时使用attach命令连到一个容器的时候, 所有窗口都会同步显示.
> # 当某个窗口因命令阻塞时, 其他窗口也无法执行操作.

> # exec进入
> docker exec -it CONTAINER-ID COMMAND
> # -i 打开标准输入接受用户输入命令, 默认false.
> # --privileged=true|false 是否给执行命令以高权限 默认false.
> # -t 分配伪终端 默认 false.
> # -u,--user='' 执行命令的用户名或ID.
> docker exec -it 16c78f8e3e11 /bin/bash
```

##### 删除容器
```bash
> # 删除处于终止态或退出状态的容器
> docker rm [-f] [-l] [-v] CONTAINER-ID
> # -f 是否强行终止并删除一个运行中的容器;
> # -l 删除容器的连接, 但保留容器;
> # -v 删除容器挂载的数据卷;
> # 默认情况下, docker rm 命令只能删除处于终止或退出状态的容器, 并不能删除处于运行状态的容器;
> # 如果要删除一个运行中的容器, 可以添加-f参数. docker会先发送SIGNKILL信号给容器, 终止其中的应用, 之后强行删除.
``` 

##### 导入和导出容器
```bash
> # 导出容器
> # -o 指定导出的tar文件名
> docker export -o tarPath CONTAINER-ID
> # 直接通过重定向存到文件
> docker export CONTAINER-ID > tarPath
```

