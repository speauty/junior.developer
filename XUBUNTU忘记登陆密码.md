#### XUBUNTU忘记登陆密码

* 重启, 进入Ubuntu 高级选项, 按Enter进入
* 选择第一个recovery mode, 键入e, 进入编辑
* 将"ro recovery nomodeset"替换为"quiet splash rw init=/bin/bash", 按Ctrl+x重启
* 使用passwd user修改对应密码
* 按Ctrl+Alt+Del重启即可