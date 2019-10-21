#### Installing Deepin QQ and Wechat on Ubuntu 18.04

*About using QQ and Wechat on Linux, more discussions on internet, so I don't want to say any more.*

* Installing Deepin-wine
   - to dowdload [`deepin-wine-ubuntu`](https://github.com/wszqkzqk/deepin-wine-ubuntu.git) from github;
   - and `cd deepin-wine-ubuntu`, to find a file named install and execute it;

* Upgrading Deepin-wine if necessary
   - According warnings, you can download the corresponding package from [ali repository](https://mirrors.aliyun.com/deepin/pool/non-free/d/deepin-wine/);
   - In the end, you can see it need a lib named `libjpeg62-turbo`, from ali repository [amd64](https://mirrors.aliyun.com/deepin/pool/main/libj/libjpeg-turbo/libjpeg62-turbo_1.5.1-2_amd64.deb), [i386](wget https://mirrors.aliyun.com/deepin/pool/main/libj/libjpeg-turbo/libjpeg62-turbo_1.5.1-2_i386.deb);
   - Then, you can upgrade some packages now using `dpkg`;

* Installing some application
   - [Wechat](https://mirrors.aliyun.com/deepin/pool/non-free/d/deepin.com.wechat/deepin.com.wechat_2.6.8.65deepin0_i386.deb): `sudo dpkg -i deepin.com.wechat_2.6.8.65deepin0_i386.deb`;
   - [Tim](https://mirrors.aliyun.com/deepin/pool/non-free/d/deepin.com.qq.office/deepin.com.qq.office_2.0.0deepin4_i386.deb): `sudo dpkg -i deepin.com.qq.office_2.0.0deepin4_i386.deb`;


If this way too difficult, you can do it from this [link](https://container-automation.readthedocs.io/zh_CN/latest/docker/gui/%5BDocker%5D%5BUbuntu%2018.04%5Ddeepin-wine%E5%88%B6%E4%BD%9C.html).
