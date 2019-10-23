#### Docker on Ubuntu

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
> # 简单查看docker版本号
> docker -v
Docker version 18.09.7, build 2d0083d

> # 使用systemctl管理docker服务
```
##### 获取镜像
```bash
> # 从Docker Hub镜像源下载镜像
> # registry-注册服务器, 默认使用Docker Hub服务
> # NAME-镜像名 TAG-镜像标签,默认为latest
> docker pull [registry]NAME[:TAG]
> # -a, --all-tags=true|false: 是否获取仓库中的所有镜像, 默认false.
> # 比如, 下载centos 7.6.1810版本
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
> # 更多参数, 使用 man docker images查看

> # 使用docker tag为本地镜像任意添加新的标签, 相当于链接(快捷方式)
> # NEWNAME必须全为小写字母, 否则会报错
Error parsing reference: "localCentOS:76" is not a valid repository/tag: invalid reference format: repository name must be lowercase
> docker tag NAME:TAG NEWNAME:NEWTAG
> docker tag centos:7.6.1810 local-centos:76
> # 上面那个镜像的镜像ID还是保持一致的, 可以看出docker tag只是添加了一个快捷方式, 并不影响实际文件

> # 使用inspect查看详细信息
> # 使用docker inspect可以获取该镜像的详细信息, 包括制作者/适应架构/各层的数字摘要等
> docker inspect NAME:TAG
> # 可使用参数-f指定其中一项内容
> docker inspect local-centos:76 -f {{".Architecture"}}

> # 查看镜像历史
> # 使用history列出各层的创建信息
> docker history local-centos:76
> # 不过由于过长被自动截断, 可添加--no-trunc显示完整
```


