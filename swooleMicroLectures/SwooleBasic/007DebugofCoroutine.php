<?php
/**
 * Author:  Speauty
 * Email:   speauty@163.com
 * File:    007DebugofCoroutine.php
 * Created: 2019/12/2 下午7:39
 */
/*Co\run(function() {
    Co::sleep(1000);
});*/

/**
 * gdb调试 中途进入
 * 启动脚本 php script.php, 并查看进程pid
 * 进入gdb: sudo gdb
 * 进入进程 attach pid
 * bt 查看堆栈
 * 载入swoole源码包中的一个调试脚本 gdbinit
 * source /home/speauty/Downloads/swoole-src-4.4.12/gdbinit
 * 使用co_list可查看当前协程
 * co_bt 1 可查看1号协程的调用堆栈
(gdb) co_list
coroutine 1 SW_CORO_WAITING
(gdb) co_bt 1
coroutine cid: [1]
[0x7f5421e06130] Swoole\Coroutine->sleep(1000) [internal function]
 */

/*Co::set([
    'log_level' => SWOOLE_LOG_INFO,
    'trace_flags' => 0
]);

Co\run(function() {
    go(function() {var_dump(Co::sleep(1));});
    go(function() {var_dump(Co::getHostByName('www.baidu.com'));});
    go(function() {var_dump(Co::statvfs(__FILE__));});
    go(function() {var_dump(Co::readFile(__FILE__));});
});*/
/**
 * gdb调试
 * gdb --args php 007DebugofCoroutine.php
 * r -- run 执行程序
 * b breakpoint 打断点 内置函数 有名字的
 * zif--function zim--method
 * b zif_var_dump
 * c continue
 * 还是要载入gdbinit, 方便查看
 * reactor_info 查看react信息
(gdb) reactor_info
reactor id: 0
running: 1
event_num: 1 事件计数 Co::sleep
aio_task_num: 3 多线程任务计数
max_event_num: 4096
check_timer: 1
timeout_msec: 1000

 * timer_list
(gdb) timer_list
current timer number: 1, round: 0
timer[1] exec_msec:1000 round:0

 * co_status
 */

/**
 * php调试协程
 */
co::set([
    'log_level' => SWOOLE_LOG_INFO,
    'trace_flags' => 0
]);

Co\run(function() {
    go(function() {var_dump(Co::sleep(1));});
    go(function() {var_dump(Co::getHostByName('www.baidu.com'));});
    go(function() {var_dump(Co::statvfs(__FILE__));});
    go(function() {var_dump(Co::readFile(__FILE__));});
    \Swoole\Timer::after(1, function() {});

    /** debug */
    \Swoole\Coroutine::create(function() {
        var_dump(Swoole\Coroutine::stats());
        foreach (\Swoole\Coroutine::list() as $cid) {
            $trace = \Swoole\Coroutine::getBackTrace($cid);
            var_dump($trace);
        }

        var_dump(Swoole\Coroutine::stats());
        foreach (\Swoole\Coroutine::list() as $tid) {
            var_dump(\Swoole\Timer::info($tid));
        }
    });
});
