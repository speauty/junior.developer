### VirtualBox配置共享文件夹

* 环境参数

  * VirtualBox 5.2.16 r123759 (Qt5.6.2)
  * 本地系统 Win7 Service Pack 1 旗舰版
  * 虚拟机系统 CentOS7

* 将virtualbox中 VBoxGuestAdditions.iso 镜像文件挂载到存储中

  ```
  mount /dev/cdrom /mnt/cdrom
  sh /mnt/cdrom/VBoxGuestAdditions.run
  // 这里会出现一个错误，可忽略
  // 然后在菜单中，控制->共享文件夹->添加即可 注意共享文件名称
  mount -t vboxsf VBoxShare[共享文件名称] /usr/local/test[共享的目标地址]
  ```

* 按照上述命令操作，即可配置完成

* 注意错误

  * 直接使用 设备->安装增强功能 可能找不到镜像文件
  * bzip2 not found 
    * 使用yum安装 `yum install bzip2`