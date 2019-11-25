### 通过putty-key生成秘钥登录linux笔记

------

- 先准备相关软件[PUTTY](https://the.earth.li/~sgtatham/putty/latest/w64/putty.zip)

- 和一个linux操作系统，本实例所用为centos7虚拟机

- 以下为具体操作步骤：

  - 打开PUTTYGEN.EXE软件，生成秘钥公钥

    点击 Generate ，将鼠标在 Key 框内滑动，可生成秘钥


  - 保存私钥!!!点击 Save private key 即可将私钥文件(.ppk)保存下来，该文件很重要，请注意保存，至于公钥，可从该ppk文件中导出

  - 配置授权公钥，将上图红线标注部分中，复制ssh-rsa那串字符，以下简称为公钥

  - 登录linux系统，如果没有该目录~/.ssh，请创建相应目录及文件

    mkfile .ssh 											创建.ssh目录

    touch authorized_keys 					   创建授权公钥文件

    chmod 700 .ssh 								   设置.ssh目录读写执行权限

    chmod 600 .ssh/authorized_keys 	 设置authorized_keys读写权限

  - 将公钥复制到authorized_keys文件中保存

  - 重启sshd服务

  - 使用putty软件，载入ppk文件

  - 点击session，填入ip

  - 点击open，按照提示，输入username，即可登录

- 如果登录失败，例如

  - 继续打开putty-key，选择 Load ，载入之前保存的私钥ppk文件

  - 重复登录服务器配置公钥，到重启sshd服务即可
  
    
  
- 至于openssh的秘钥和ppk文件的转换，可自行百度，也可加我QQ[1317678655]寻求帮助，请备注来意