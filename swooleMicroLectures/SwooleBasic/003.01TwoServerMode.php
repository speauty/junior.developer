<?php
/**
 * Author:  Speauty
 * Email:   speauty@163.com
 * File:    004TwoServerMode.php
 * Created: 2019/11/26 下午9:21
 */

/**
 * Http Server 两种运行模式(swoole 4以后, 就只有两种) SWOOLE_PROCESS(默认) SWOOLE_BASE
 */

/**
 * SWOOLE_PROCESS
 * Master进程  Master线程  Reactor对象 Reactor线程 心跳检测线程 UDP收包线程
 * Manager进程
 * Worker进程
 * Task进程 属于Worker进程
 */