#### PHP编译常见问题总结

1. 编译CURL: cURL 7.15.5 or greater

curl版本过低, 需升级, 使用`curl --version`查看当前版本, 已经达到要求, 那么可能是curl的其他类未达到要求, 经过查询得知: ` sudo apt-get install curl libcurl3 libcurl3-dev`, 安装后, 重新编译curl, 就没得问题了, 我的是deepin.