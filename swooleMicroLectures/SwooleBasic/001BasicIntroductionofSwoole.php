<?php
/**
 * Author:  Speauty
 * Email:   speauty@163.com
 * File:    001BasicIntroductionofSwoole.php
 * Created: 2019/11/25 下午10:52
 */

/** Swoole是一个为PHP用C和C++编写的基于事件的高性能异步&协程并行网络通信引擎 */

/**
 * 同步: 代码按顺序执行
 * 异步: 注册事件, 非顺序执行, 监听事件, 触发回调处理
 * 协程: 可简单理解为超轻量级(就上下文大小来说)线程, 不会阻塞当前进程
 */

/**
 * 通道(channel): 协程之间通信交换数据的唯一渠道, 而协程+通道的开发组合即为CSP编程模型
 * 在swoole中, channel常用于连接池的实现和协程并发的调度
 */