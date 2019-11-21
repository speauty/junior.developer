### BusyBox Commands Learning


#### 关于`BusyBox`

`BusyBox`被称作"Linux系统的瑞士军刀", 它是由许多常见的`UNIX`工具精简版组成的一个很小的可执行程序, 更多参考[官网介绍](https://busybox.net/about.html).


#### 学习计划

之前, 统计过, 共有399命令, 按照每日一个, 需要13个月左右, 但实际时间是不可能这样安排的, 也还是要根据命令的难度. 所以不可一概而论, 我想的是, 大约用三个月搞定这些, 当然, 也只是全部跑一边, 做下记录, 不可能去死记硬背的.

对了, 还要说一个情况, 我也是才注意, 这是`UNIX`系, 我之前还和`LINUX`系比较, 是感觉差距很大, 太可爱了.

废话不多说了, 进入正题, 按照`/bin`下顺序进行.


#### 命令学习

##### 0000.[官方命令参考链接](https://busybox.net/downloads/BusyBox.html)

##### 001. acpid
```
Usage: acpid [-df] [-c CONFDIR] [-l LOGFILE] [-a ACTIONFILE] [-M MAPFILE] [-e PROC_EVENT_FILE] [-p PIDFILE]
Listen to ACPI events and spawn specific helpers on event arrival
监听ACPI事件并在事件到达时执行特殊的辅助程序来处理
	-d	Log to stderr, not log file (implies -f)
	-f	Run in foreground
	-c DIR	Config directory [/etc/acpi]
	-e FILE	/proc event file [/proc/acpi/event]
	-l FILE	Log file [/var/log/acpid.log]
	-p FILE	Pid file [/var/run/acpid.pid]
	-a FILE	Action file [/etc/acpid.conf]
	-M FILE Map file [/etc/acpi.map]
Accept and ignore compatibility options -g -m -s -S -v

据[ARCHWIKI](https://wiki.archlinux.org/index.php/acpid), ACPID是一种灵活的, 可扩展的用于传递ACPI事件的守护进程. 当事件发生时, 它执行程序来处理事件.
```

##### 002. add-shell
```
Usage: add-shell SHELL...
Add SHELLs to /etc/shells
```

##### 003. addgroup
```
Usage: addgroup [-g GID] [-S] [USER] GROUP
Add a group or add a user to a group
添加一个用户组或添加一个用户到用户组
	-g GID	Group id
	-S	Create a system group

创建一个GID为1000名为test的用户组
addgroup -g 1000 test
可在用户组信息文件中查看
vi /etc/group
test:x:1000:
组名:口令:组标识号:组内用户列表
口令: 存放的是用户组加密后的口令字串, 密码默认设置在/etc/gshadow文件中, 而在这里用“x”代替, linux系统下默认的用户组都没有口令, 可以通过gpasswd来给用户组添加密码
```

##### 004. adduser
```
Usage: adduser [OPTIONS] USER [GROUP]
Create new user, or add USER to GROUP
创建新用户, 或添加用户到用户组
	-h DIR		Home directory
	-g GECOS	GECOS field
	-s SHELL	Login shell
	-G GRP		Group
	-S		Create a system user
	-D		Don't assign a password
	-H		Don't create home directory
	-u UID		User id
	-k SKEL		Skeleton directory (/etc/skel)


adduser -G test test
因为没加-D参数, 会让输入密码
加好之后, 先看一下 /etc/group
test:x:1000:test
是符合之前说的格式
再来看几个相关的文件
用户文件 /etc/passwd
test:x:1000:1000:Linux User,,,:/home/test:/bin/sh
参考链接: https://www.jianshu.com/p/76700505cac4
用户名:口令:用户标识号:组标识号:注释描述:主目录:默认shell
口令: 存放着加密后的用户口令, 这个字段存放的只是用户口令的加密串, 不是明文. 但是/etc/passwd文件所有用户都可以读, 所以这是个安全隐患, 所以许多Linux版本中使用shadow技术, 把真正加密后的用户口令存放在/etc/shadow中, 而在/etc/passwd文件中用x或者*代替. 稍后, 去看一下就知道了
UID取值范围: 通常UID的取值范围为0~65535. 0是超级用户root的标识号, 1~99由系统保留作为管理账号. 普通用户是从100开始的, 而Linux中默认是从500开始的
创建一个名test的用户, 并把该用户加到test用户组去
组标识号: 就是组的GID, 与用户的UID类似, 这个字段记录了用户所属的用户组, 它对应着/etc/group/文件中的一条记录
注释描述: 是对用户的描述信息, 比如电话, 住址, 姓名等等
主目录：是用户登录到系统之后默认的目录
默认shell: 用户登录到系统后默认使用的命令解释器, shell是用户和Linux内核之间的接口, 用户所做的任何操作, 都是通过shell传递给系统内核的. Linux下常用的shell有: sh,bash,csh等, 管理员可以根据用户的习惯, 为用户设置不同的shell

用户加密咨询文件 /etc/shadow
test:a46PaBaWc0NC2:18220:0:99999:7:::
用户名:加密口令:最后一次修改时间:最小时间间隔:最大时间间隔:警告时间:不活动时间:失效时间:保留字段
加密口令: 存放的是用户口令加密后的字符串, 如果此字段是*！x这三个字符, 则对应的用户不能登录系统
最后一次修改时间: 表示从某个时间起, 到最近一次修改口令的间隔天数
最小时间间隔: 表示两次修改密码之间的最小时间间隔
最大时间间隔: 表示两次修改密码之间的最大时间间隔, 这个设置能增强管理员管理用户的时效性
警告时间: 表示系统开始警告用户到密码正式失效的天数
不活动时间: 此字段表示用户口令作废多少天后, 系统会禁用此用户, 也就是说系统不再让此用户登录, 也不会提示用户过期, 是完全禁用
失效时间: 表示该用户的帐号生存期, 超过这个设定时间, 帐号失效, 用户就无法登录系统了. 如果这个字段的值为空, 帐号永久可用
保留字段: linux的保留字段, 目前为空, 以备linux日后发展之用
```

##### 005. adjtimex
```
Usage: adjtimex [-q] [-o OFF] [-f FREQ] [-p TCONST] [-t TICK]
Read or set kernel time variables. See adjtimex(2)
显示或者修改linux内核的时间变量
	-q	Quiet
	-o OFF	Time offset, microseconds
	-f FREQ	Frequency adjust, integer kernel units (65536 is 1ppm)
	-t TICK	Microseconds per tick, usually 10000
		(positive -t or -f values make clock run faster)
	-p TCONST

更多参考: http://www.man7.org/linux/man-pages/man2/adjtimex.2.html
```

##### 006. ar
```
Usage: ar [-o] [-v] [-p] [-t] [-x] ARCHIVE FILES
Extract or list FILES from an ar archive
	-o	Preserve original dates
	-p	Extract to stdout
	-t	List
	-x	Extract
	-v	Verbose

据百度百科, ar是一个备份压缩命令, 用于创建,修改备存文件(archive), 或从备存文件中提取成员文件. ar命令最常见的用法是将目标文件打包为静态链接库
```

##### 007. arch
```
Usage: arch
Print system architecture
输出系统架构
```

##### 008. arp
```
Usage: arp
[-vn]	[-H HWTYPE] [-i IF] -a [HOSTNAME]
[-v]		    [-i IF] -d HOSTNAME [pub]
[-v]	[-H HWTYPE] [-i IF] -s HOSTNAME HWADDR [temp]
[-v]	[-H HWTYPE] [-i IF] -s HOSTNAME HWADDR [netmask MASK] pub
[-v]	[-H HWTYPE] [-i IF] -Ds HOSTNAME IFACE [netmask MASK] pub
Manipulate ARP cache
管理ARP缓存
	-a		Display (all) hosts
	-d		Delete ARP entry
	-s		Set new entry
	-v		Verbose
	-n		Don't resolve names
	-i IF		Network interface
	-D		Read HWADDR from IFACE
	-A,-p AF	Protocol family
	-H HWTYPE	Hardware address type

据百度百科, ARP, 全称Address Resolution Protocol, 地址解析协议, 根据IP地址获取物理地址的一个TCP/IP协议
主机发送信息时将包含目标IP地址的ARP请求广播到局域网络上的所有主机, 并接收返回消息, 以此确定目标的物理地址, 收到返回消息后将该IP地址和物理地址存入本机ARP缓存中并保留一定时间, 下次请求时直接查询ARP缓存以节约资源
地址解析协议是建立在网络中各个主机互相信任的基础上的, 局域网络上的主机可以自主发送ARP应答消息, 其他主机收到应答报文时不会检测该报文的真实性就会将其记入本机ARP缓存, 由此攻击者就可以向某一主机发送伪ARP应答报文, 使其发送的信息无法到达预期的主机或到达错误的主机, 这就构成了一个ARP欺骗
ARP缓存中包含一个或多个表, 它们用于存储IP地址及其经过解析的MAC地址
ARP命令用于查询本机ARP缓存中IP地址-->MAC地址的对应关系,添加或删除静态对应关系等

arp
地址                     类型    硬件地址            标志  Mask            接口
_gateway                 ether   d0:76:e7:87:0b:2c   C                     ens133
192.168.101.105          ether   50:8f:4c:53:90:a7   C                     ens133

添加静态映射
arp -i eth0 -s 192.168.1.6 ff:ee:ee:ee:ee:ee
删除静态映射
arp -i eth0 -d 192.168.1.6 ff:ee:ee:ee:ee:ee
```

##### 009. arping
```
Usage: arping [-fqbDUA] [-c CNT] [-w TIMEOUT] [-I IFACE] [-s SRC_IP] DST_IP
Send ARP requests/replies
	-f		Quit on first ARP reply
	-q		Quiet
	-b		Keep broadcasting, don't go unicast
	-D		Exit with 1 if DST_IP replies
	-U		Unsolicited ARP mode, update your neighbors
	-A		ARP answer mode, update your neighbors
	-c N		Stop after sending N ARP requests
	-w TIMEOUT	Seconds to wait for ARP reply
	-I IFACE	Interface to use (default eth0)
	-s SRC_IP	Sender IP address
	DST_IP		Target IP address

arping -f -I ens133  192.168.101.134
ARPING 192.168.101.134 from 192.168.101.130 ens133
Unicast reply from 192.168.101.134 [00:F1:F3:C3:01:F8]  0.716ms
Sent 1 probes (1 broadcast(s))
Received 1 response(s)
```

##### 010. ash
```
Usage: ash [-/+OPTIONS] [-/+o OPT]... [-c 'SCRIPT' [ARG0 [ARGS]] / FILE [ARGS] / -s [ARGS]]
Unix shell interpreter

Shell既是一种脚本编程语言, 也是一个连接内核和用户的软件
常见的Shell有sh, bash, csh, tcsh, ash等
sh: 全称是Bourne shell, 由AT&T公司的Steve Bourne开发, 是UNIX上的标准shell
csh: 由柏克莱大学的Bill Joy设计的, 语法有点类似C语言, 所以才得名为C shell, 简称为csh
tcsh: csh的增强版, 加入了命令补全功能, 提供了更加强大的语法支持
ash: 一个简单的轻量级的Shell, 占用资源少, 适合运行于低内存环境
bash: 由GNU组织开发, 保持了对sh shell的兼容性, 是各种Linux发行版默认配置的shell
```

##### 011. awk
```
Usage: awk [OPTIONS] [AWK_PROGRAM] [FILE]...
	-v VAR=VAL	Set variable
	-F SEP		Use SEP as field separator
	-f FILE		Read program from FILE
	-e AWK_PROGRAM

简单试了一下, 还是可以
echo "fasd@fasd@fasdf#" |awk -F @ "{print $1}"
更多参考: http://www.gnu.org/software/gawk/manual/gawk.html
```



