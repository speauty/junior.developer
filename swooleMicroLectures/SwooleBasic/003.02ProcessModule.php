<?php
/**
 * Author:  Speauty
 * Email:   speauty@163.com
 * File:    005ProcessModule.php
 * Created: 2019/11/26 下午9:39
 */


/** 需安装pcntl扩展 */
/*$pid = pcntl_fork();
var_dump($pid);
if ($pid !== 0) {
    echo 'I am a parent process'.PHP_EOL;
} else {
    var_dump(getmypid());
    echo "I am a sub process".PHP_EOL;
}*/

/**
 * swoole默认把子进程的输出重定到父进程
 */
$process = new Swoole\Process(function() {
    echo "Swoole".PHP_EOL;
});
/** 开启子进程 */
$process->start();
/** 回收子进程 */
$process::wait();

/**
 * 创建进程 代价昂贵
 */
//$start = microtime(true);
//for ($n = 100;$n--;) {
//    /** 创建子进程(两个) */
//    `echo foo|grep f`;
//}
//var_dump(microtime(true)-$start);

//$start = microtime(true);
//for ($n = 100;$n--;) {
//    ob_clean();
//    echo 'foo';
//    preg_match('/f/', ob_get_clean(), $matches);
//}
//var_dump(microtime(true)-$start);

/**
 * 开进程的开销, 也要合理规划, 不可太莽了
 * 比如swoole的task进程, 要合理规划, 真正目的主要是把一些无法把同步阻塞转换成异步非阻塞的处理放到task
 */