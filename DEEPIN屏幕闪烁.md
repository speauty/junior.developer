问题描述: 使用该系统, 在滑动时, 屏幕会发生闪烁现象.

使用系统: DEEPIN 15.11 桌面版.

AMD的集成显卡.

上述问题描述与系统和我搜到的帖子几乎是一样的, 不过为了方便某些"懒人", 我还是秉着人道主义精神, 做一下简单的描述.

安装 KDE系统设置 软件: `sudo apt install systemsettings`.

安装完成打开 KDE系统设置, 滑到最下面, 找到显示与监控, 双击进入, 将`Render backend`改为`XRender`, 随后点击应用即可.

参考链接
* [AMD集成显卡使用时屏幕闪烁](https://github.com/linuxdeepin/internal-discussion/issues/1709);