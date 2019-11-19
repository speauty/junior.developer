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

> # 导入容器
> docker import tarPath - REPOSITORY/NAME:TAG
> # 将导出的文件使用docker import导入变成镜像
```
##### Docker Hub 公共镜像市场
```bash
> # 登录
> docker login
> # 用户在登录后可通过docker push将本地镜像推送到docker hub

> # 配置自动创建
> # 1. 创建并登录docker hub, 以及目标网站;在目标网站中连接账户到docker;
> # 2. 在docker hub中配置一个自动创建;
> # 3. 选取一个目标网站中的项目(需要含docker file)和分支;
> # 4. 指定dockerfile的位置, 并提交创建

> # 时速云的注册服务器地址 index.tenxcloud.com
```

##### 创建本地私有仓库
```bash
> # 使用Registry镜像创建私有仓库
> # 自动下载并启动一个registry容器, 创建本地的私有仓库服务
> docker run -d -p 5000:5000 registry
> # 默认情况下, 会将仓库创建在容器的/tmp/registry目录下, 可以通过-v参数来将镜像文件存放在本地的指定路径(必须为小写字母)
> docker run -d -p 5000:5000 -v /opt/data/registry:/tmp/registry registry
```

##### 数据卷
```bash
> # 容器中管理数据主要的两种方式
> 数据卷: 容器内数据直接映射到本地主机环境
> 数据卷容器: 使用特定容器维护数据卷

> # 1. 在容器内创建一个数据卷
> # 使用-v标记可以在容器内创建一个数据卷, 可重复使用
> # -P是将容器服务暴露的端口, 是自动映射到本地主机的临时端口
> docker run -d -P --name test -v /testwww local-centos:76
> # 创建一个容器, 并创建一个数据卷挂在到容器的/testwww目录

> # 2. 挂载一个主机目录作为数据卷
> # 使用-v标记也可以指定挂载一个本地的已有目录到容器中去作为数据卷
> docker run -d -P --name test -v /src/testwww:/opt/testwww local-centos:76
> # 加载主机的/src/testwww目录到容器的/opt/testwww目录
> # 本地目录的路径必须是绝对路径, 如果目录不存在, docker会自动创建
> # docker挂在数据卷的默认权限是读写(rw), 也可通过ro指定为只读, 容器内对所挂载数据卷内的数据就无法修改了
> docker run -d -P --name test -v /src/testwww:/opt/testwww:ro local-centos:76

> # 3. 挂载一个本地主机文件作为数据卷
> # -v标记也可以从主机挂载单个文件到容器中作为数据卷
> docker run --rm -it -v ~/.bash_history:/.bash_history local-centos:76 /bin/bash
```

##### 数据卷容器
```bash
> # 数据卷容器也是一个容器, 但是它的目的是专门用来提供数据卷供其他容器挂载

> # 创建一个数据卷容器, 并创建一个数据卷挂载
> # 在其他容器中使用-volumes-from可以挂载数据卷容器的数据卷
> docker run -it -v /dbdata --name db local-centos:76 /bin/bash
> # 创建两个挂载数据卷容器数据卷的其他容器容器
> docker run -it --volumes-from db --name test_db1 local-centos:76 
> docker run -it --volumes-from db --name test_db2 local-centos:76
> # 可以多次使用--volumes-from从多个容器挂载多个数据卷. 还可以从其他已挂载的容器卷的容器来挂载数据卷

> # 使用--volumes-from参数所挂载数据卷的容器自身并不需要保持在运行状态
> # 如果删除了挂载的容器(包括db/test_db1/test_db2), 数据卷并不会被自动删除. 如果要一个数据卷, 必须在删除最后一个还挂载着它的容器时显示使用docker rm -v命令来指定同时删除关联的容器
> # 使用数据卷容器可以让用户在容器之间自由地升级和移动数据卷

> # 利用数据卷容器来迁移数据
> # 1. 备份
> docker run --columes-from db -v $(pwd):/backup --name worker local-centos:76 tar cvf /backup/backup.tar /dbdata
> # $(pwd) 当前路径
> # tar cvf 仅打包不压缩, 这里是将/dbdata目录打包到/backup/backup.tar文件中, 通过数据卷共享到本地

> # 2. 恢复
> # 先创建一个带数据卷的容器
> docker run -v /dbdata --name db local-centos:76 /bin/bash
> # 再创建一个新容器, 挂载db的容器, 并使用untar解压备份文件到所挂载的容器卷中
> docker run --volumes-from db -v $(pwd):/backup busybox tar xvf /backup/backup.tar
```



