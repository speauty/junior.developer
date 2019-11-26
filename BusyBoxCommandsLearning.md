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

据ARCHWIKI, ACPID是一种灵活的, 可扩展的用于传递ACPI事件的守护进程. 当事件发生时, 它执行程序来处理事件.
```
* ###### [acpid](https://wiki.archlinux.org/index.php/acpid)

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
* ###### [Linux中的用户和用户组](https://www.jianshu.com/p/76700505cac4)

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
```
* ###### [adjtimex](http://www.man7.org/linux/man-pages/man2/adjtimex.2.html)

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
```
* ###### [gawk](http://www.gnu.org/software/gawk/manual/gawk.html)

##### 012. base64
```
Usage: base64 [-d] [FILE]
Base64 encode or decode FILE to standard output
	-d	Decode data

将文件经base64加密或解密到标准输出
echo "fdsadfs" |base64|base64 -d
fdsadfs
```

##### 013. basename
```
Usage: basename FILE [SUFFIX]
Strip directory path and .SUFFIX from FILE

将路径和后缀过滤掉, 获取文件名称
basename test.txt
test.txt
basename test.txt txt
test.
basename test.txt .txt
test
```

##### 014. bc
```
Usage: bc [-sqlw] FILE...
Arbitrary precision calculator
	-q	Quiet
	-l	Load standard math library
	-s	Be POSIX compatible
	-w	Warn if extensions are used
$BC_LINE_LENGTH changes output width

任意精度计算器
进入之后, 输入quit退出

就当做windows下的计算器使用吧
```

##### 015. beep
```
Usage: beep -f FREQ -l LEN -d DELAY -r COUNT -n
	-f	Frequency in Hz
	-l	Length in ms
	-d	Delay in ms
	-r	Repetitions
	-n	Start new tone

beep -f 800 -l 125 -D 125 -r 2
beep: can't open console

尴尬了, 蜂鸣失败, 不能打开控制台
```

##### 016. blkdiscard
```
Usage: blkdiscard [-o OFS] [-l LEN] [-s] DEVICE
Discard sectors on DEVICE
	-o OFS	Byte offset into device
	-l LEN	Number of bytes to discard
	-s	Perform a secure discard

删除设备上的扇区, 感觉也不是个随便玩的命令
```
* ###### [blkdiscard](http://www.linuxguruz.com/man-pages/blkdiscard/)

##### 017. blkid
```
Usage: blkid [BLOCKDEV]...
Print UUIDs of all filesystems

输出所有文件系统的UUID, 在工作这台电脑上, 没有任何响应, 即使安装了e2fsprogs
但是在个人PC上, 有响应, 我想起了, 工作电脑, 没分区...
```

##### 018. blockdev
```
Usage: blockdev OPTION BLOCKDEV
	--setro		Set ro  设置设备为只读
	--setrw		Set rw  设置设备为可读写
	--getro		Get ro  读取设备是否为只读(成功为1,0则为可读写)
	--getss		Get sector size
	--getbsz	Get block size
	--setbsz BYTES	Set block size
	--getsz		Get device size in 512-byte sectors
	--getsize64	Get device size in bytes
	--flushbufs	Flush buffers
	--rereadpt	Reread partition table
从命令行调用区块设备控制程序(ioctl)
```

##### 019. bootchartd
```
Usage: bootchartd start [PROG ARGS]|stop|init
Create /var/log/bootchart.tgz with boot chart data
start: start background logging; with PROG, run PROG, then kill logging with USR1
stop: send USR1 to all bootchartd processes
init: start background logging; stop when getty/xdm is seen (for init scripts)
Under PID 1: as init, then exec $bootchart_init, /init, /sbin/init

应该是启动数据记录下来, 作分析使用的
```

##### 020. brctl
```
Usage: brctl COMMAND [BRIDGE [ARGS]]
Manage ethernet bridges
Commands:
	show [BRIDGE]...	Show bridges
	addbr BRIDGE		Create BRIDGE
	delbr BRIDGE		Delete BRIDGE
	addif BRIDGE IFACE	Add IFACE to BRIDGE
	delif BRIDGE IFACE	Delete IFACE from BRIDGE
	stp BRIDGE 1/yes/on|0/no/off	STP on/off
	setageing BRIDGE SECONDS	Set ageing time
	setfd BRIDGE SECONDS		Set bridge forward delay
	sethello BRIDGE SECONDS		Set hello time
	setmaxage BRIDGE SECONDS	Set max message age
	setbridgeprio BRIDGE PRIO	Set bridge priority
	setportprio BRIDGE IFACE PRIO	Set port priority
	setpathcost BRIDGE IFACE COST	Set path cost

管理以太网桥(网卡)
brctl show 
bridge name	bridge id		STP enabled	interfaces
docker0		8000.024204af0bef	no		veth6ef444e

激活STP
sudo brctl stp docker0 1
brctl show
bridge name	bridge id		STP enabled	interfaces
docker0		8000.024204af0bef	yes		veth6ef444e

创建一个网卡
sudo brctl addbr brtest0
需要桥接的网卡IP清空(这不就不用了, 害怕搞砸, 直接桥接)
sudo ifconfig eth0 0 up
在"brtest0"上添加"ens133"
sudo brctl addif brtest0 ens133
给"brtest0"配置IP 192.168.101.189
sudo ifconfig  brtest0 192.168.101.189 /24 up
设置默认的网关地址, 这个也不用操作
route add default gw 192.168.101.1
顺便激活STP协议

删除一波
先解绑
sudo brctl delif brtest0 ens133
再网卡下线
sudo ifconfig brtest0 down
删除即可
sudo brctl delbr brtest0

刚把百度整丢了, 重启网络服务, 然后就可以访问百度了
sudo service network-manager restart
```
* ###### [Linux STP介绍](https://www.cnblogs.com/hzl6255/p/3259909.html)
* ###### STP(Spanning Tree Protocol)即生成树协议, 标准为[IEEE802.1D-1998](http://ylescop.free.fr/mrim/protocoles/802/802.1D-1998.pdf), 是一种二层冗余技术, 利用STA算法构建一个逻辑上没有环路的树形网络拓扑结构, 并且可以通过一定的方法实现路径冗余
* ###### [brctl创建虚拟网卡详解](https://www.cnblogs.com/yinzhengjie/p/7446226.html)

##### 021. bunzip2
```
Usage: bunzip2 [-cfk] [FILE]...
Decompress FILEs (or stdin)
	-c	Write to stdout
	-f	Force
	-k	Keep input files

解压.bz2文件
```

##### 022. busybox
```
BusyBox is copyrighted by many authors between 1998-2015.
Licensed under GPLv2. See source distribution for detailed
copyright notices.
Usage: busybox [function [arguments]...]
   or: busybox --list[-full]
   or: busybox --show SCRIPT
   or: busybox --install [-s] [DIR]
   or: function [arguments]...
	BusyBox is a multi-call binary that combines many common Unix
	utilities into a single executable.  Most people will create a
	link to busybox for each function they wish to use and BusyBox
	will act like whatever it was invoked as.
Currently defined functions:
	[, [[, acpid, add-shell, addgroup, adduser, adjtimex, ar, arch, arp, arping, ash, awk, base64, basename, bc, beep, blkdiscard, blkid, blockdev, bootchartd, brctl, bunzip2, bzcat, bzip2, cal, cat,
	chat, chattr, chgrp, chmod, chown, chpasswd, chpst, chroot, chrt, chvt, cksum, clear, cmp, comm, conspy, cp, cpio, crond, crontab, cryptpw, cttyhack, cut, date, dc, dd, deallocvt, delgroup,
	deluser, depmod, devmem, df, dhcprelay, diff, dirname, dmesg, dnsd, dnsdomainname, dos2unix, dpkg, dpkg-deb, du, dumpkmap, dumpleases, echo, ed, egrep, eject, env, envdir, envuidgid, ether-wake,
	expand, expr, factor, fakeidentd, fallocate, false, fatattr, fbset, fbsplash, fdflush, fdformat, fdisk, fgconsole, fgrep, find, findfs, flock, fold, free, freeramdisk, fsck, fsck.minix, fsfreeze,
	fstrim, fsync, ftpd, ftpget, ftpput, fuser, getopt, getty, grep, groups, gunzip, gzip, halt, hd, hdparm, head, hexdump, hexedit, hostid, hostname, httpd, hush, hwclock, i2cdetect, i2cdump,
	i2cget, i2cset, i2ctransfer, id, ifconfig, ifdown, ifenslave, ifplugd, ifup, inetd, init, insmod, install, ionice, iostat, ip, ipaddr, ipcalc, ipcrm, ipcs, iplink, ipneigh, iproute, iprule,
	iptunnel, kbd_mode, kill, killall, killall5, klogd, last, less, link, linux32, linux64, linuxrc, ln, loadfont, loadkmap, logger, login, logname, logread, losetup, lpd, lpq, lpr, ls, lsattr,
	lsmod, lsof, lspci, lsscsi, lsusb, lzcat, lzma, lzop, makedevs, makemime, man, md5sum, mdev, mesg, microcom, mkdir, mkdosfs, mke2fs, mkfifo, mkfs.ext2, mkfs.minix, mkfs.vfat, mknod, mkpasswd,
	mkswap, mktemp, modinfo, modprobe, more, mount, mountpoint, mpstat, mt, mv, nameif, nanddump, nandwrite, nbd-client, nc, netstat, nice, nl, nmeter, nohup, nologin, nproc, nsenter, nslookup, ntpd,
	nuke, od, openvt, partprobe, passwd, paste, patch, pgrep, pidof, ping, ping6, pipe_progress, pivot_root, pkill, pmap, popmaildir, poweroff, powertop, printenv, printf, ps, pscan, pstree, pwd,
	pwdx, raidautorun, rdate, rdev, readahead, readlink, readprofile, realpath, reboot, reformime, remove-shell, renice, reset, resize, resume, rev, rm, rmdir, rmmod, route, rpm, rpm2cpio, rtcwake,
	run-init, run-parts, runlevel, runsv, runsvdir, rx, script, scriptreplay, sed, sendmail, seq, setarch, setconsole, setfattr, setfont, setkeycodes, setlogcons, setpriv, setserial, setsid,
	setuidgid, sh, sha1sum, sha256sum, sha3sum, sha512sum, showkey, shred, shuf, slattach, sleep, smemcap, softlimit, sort, split, ssl_client, start-stop-daemon, stat, strings, stty, su, sulogin,
	sum, sv, svc, svlogd, svok, swapoff, swapon, switch_root, sync, sysctl, syslogd, tac, tail, tar, taskset, tc, tcpsvd, tee, telnet, telnetd, test, tftp, tftpd, time, timeout, top, touch, tr,
	traceroute, traceroute6, true, truncate, ts, tty, ttysize, tunctl, ubiattach, ubidetach, ubimkvol, ubirename, ubirmvol, ubirsvol, ubiupdatevol, udhcpc, udhcpc6, udhcpd, udpsvd, uevent, umount,
	uname, unexpand, uniq, unix2dos, unlink, unlzma, unshare, unxz, unzip, uptime, users, usleep, uudecode, uuencode, vconfig, vi, vlock, volname, w, wall, watch, watchdog, wc, wget, which, who,
	whoami, whois, xargs, xxd, xz, xzcat, yes, zcat, zcip

对头, 没看错, 我就是在学这些函数
```

##### 023. bzcat
```
Usage: bzcat [FILE]...
Decompress to stdout

和上面那个差不多, 解压.bz2文件到标准输出
```

##### 024. bzip2
```
Usage: bzip2 [OPTIONS] [FILE]...
Compress FILEs (or stdin) with bzip2 algorithm
	-1..9	Compression level
	-d	Decompress
	-t	Test file integrity
	-c	Write to stdout
	-f	Force
	-k	Keep input files

使用bzip2算法压缩文件或标准输入
压缩标准输出到bz2文件
echo "fdajkdsfjkasfjklsjkdf"|bzip2 -8 > te.bz2
压缩多文件
bzip2 -c te.bz2 test.txt > ha.bz2

bzcat te.bz2 
fdajkdsfjkasfjklsjkdf
bunzip2 ha.bz2 -k
ls 
ha      ha.bz2

bzcat和bunzip2好像都是解压到同一个文件中, 所以多文件的压缩包, 解压之后, 会出现乱码
需要其他的解压工具吧
```
* ###### [bzip2](http://www.bzip.org/)

##### 025. cal
```
Usage: cal [-jy] [[MONTH] YEAR]
Display a calendar
	-j	Use julian dates
	-y	Display the entire year

显示日历, 挺好用的
```

##### 026. cat
```
Usage: cat [-nbvteA] [FILE]...
Print FILEs to stdout
	-n	Number output lines
	-b	Number nonempty lines
	-v	Show nonprinting characters as ^x or M-x
	-t	...and tabs as ^I
	-e	...and end lines with $
	-A	Same as -vte

将文件输出到标注输出
cat -n test.txt 
1	jkhf
2	fdhsajkfhsajhjf
```

##### 027. chat
```
Usage: chat EXPECT [SEND [EXPECT [SEND...]]]
Useful for interacting with a modem connected to stdin/stdout.
A script consists of "expect-send" argument pairs.
Example:
chat '' ATZ OK ATD123456 CONNECT '' ogin: pppuser word: ppppass '~'

这个命令...
```

##### 028. chattr
```
Usage: chattr [-R] [-v VERSION] [-+=AacDdijsStTu] FILE...
Change ext2 file attributes
	-R	Recurse
	-v VER	Set version/generation number
Modifiers:
	-,+,=	Remove/add/set attributes
Attributes:
	A	Don't track atime
	a	Append mode only
	c	Enable compress
	D	Write dir contents synchronously
	d	Don't backup with dump
	i	Cannot be modified (immutable)
	j	Write all data to journal first
	s	Zero disk storage when deleted
	S	Write synchronously
	t	Disable tail-merging of partial blocks with other files
	u	Allow file to be undeleted

改变存放在ext2文件系统上的文件或目录属性
```

##### 029. chgrp
```
Usage: chgrp [-RhLHPcvf]... GROUP FILE...
Change the group membership of each FILE to GROUP
	-R	Recurse
	-h	Affect symlinks instead of symlink targets
	-L	Traverse all symlinks to directories
	-H	Traverse symlinks on command line only
	-P	Don't traverse symlinks (default)
	-c	List changed files
	-v	Verbose
	-f	Hide errors

变更文件或目录的所属群组
Recurse 递归
Traverse 遍历
```

##### 030. chmod
```
Each MODE is one or more of the letters ugoa, one of the
symbols +-= and one or more of the letters rwxst
	-R	Recurse
	-c	List changed files
	-v	List all files
	-f	Hide errors

更改文件或目录权限
```

##### 031. chown
```
Usage: chown [-RhLHPcvf]... USER[:[GRP]] FILE...
Change the owner and/or group of each FILE to USER and/or GRP
	-R	Recurse
	-h	Affect symlinks instead of symlink targets
	-L	Traverse all symlinks to directories
	-H	Traverse symlinks on command line only
	-P	Don't traverse symlinks (default)
	-c	List changed files
	-v	List all files
	-f	Hide errors

更改文件或目录的所有者或所有组
```

##### 032. chpasswd
```
Usage: chpasswd [--md5|--encrypted|--crypt-method|--root]
Read user:password from stdin and update /etc/passwd
	-e,--encrypted		Supplied passwords are in encrypted form
	-m,--md5		Encrypt using md5, not des
	-c,--crypt-method ALG	des,md5,sha256/512 (default des)
	-R,--root DIR		Directory to chroot into

从标准输入中读取用户密码并更新/etc/passwd

chpasswd 
root:0000
chpasswd: password for 'root' changed
```

##### 033. chpst
```
Change the process state, run PROG
	-u USER[:GRP]	Set uid and gid
	-U USER[:GRP]	Set $UID and $GID in environment
	-e DIR		Set environment variables as specified by files
			in DIR: file=1st_line_of_file
	-/ DIR		Chroot to DIR
	-n NICE		Add NICE to nice value
	-m BYTES	Same as -d BYTES -s BYTES -l BYTES
	-d BYTES	Limit data segment
	-o N		Limit number of open files per process
	-p N		Limit number of processes per uid
	-f BYTES	Limit output file sizes
	-c BYTES	Limit core file size
	-v		Verbose
	-P		Create new process group
	-0		Close stdin
	-1		Close stdout
	-2		Close stderr
```

##### 034. chroot
```
Usage: chroot NEWROOT [PROG ARGS]
Run PROG with root directory set to NEWROOT

更改root目录来着
```

##### 035. chrt
```
Usage: chrt -m | -p [PRIO] PID | [-rfobi] PRIO PROG [ARGS]
Change scheduling priority and class for a process
	-m	Show min/max priorities
	-p	Operate on PID
	-r	Set SCHED_RR class
	-f	Set SCHED_FIFO class
	-o	Set SCHED_OTHER class
	-b	Set SCHED_BATCH class
	-i	Set SCHED_IDLE class

更改进程的调度优先级和类
```

##### 036. chvt
```
Usage: chvt N
Change the foreground virtual terminal to /dev/ttyN

切换虚拟终端
```

##### 037. cksum
```
Usage: cksum FILE...
Calculate the CRC32 checksums of FILEs

检查文件的CRC是否正确, 确保文件从一个系统传输到另一个系统的过程中不被损坏
```

##### 038. clear
```
Usage: clear
Clear screen

清屏操作
```

##### 039. cmp
```
Usage: cmp [-l] [-s] FILE1 [FILE2 [SKIP1 [SKIP2]]]
Compare FILE1 with FILE2 (or stdin)
	-l	Write the byte numbers (decimal) and values (octal)
		for all differing bytes
	-s	Quiet

比较两个文件
```

##### 040. comm
```
Usage: comm [-123] FILE1 FILE2
Compare FILE1 with FILE2
	-1	Suppress lines unique to FILE1
	-2	Suppress lines unique to FILE2
	-3	Suppress lines common to both files

比较两个文件, 显示共有的
-1 不显示只在文件1中出现的行
-2 不显示只在文件2中出现的行
-3 显示在两个文件中都出现了的行
```