<?php
/**
 * Author:  Speauty
 * Email:   speauty@163.com
 * File:    006Pressure.php
 * Created: 2019/11/26 下午10:23
 */
use Swoole\Http\Request;
use Swoole\Http\Response;

$http = new Swoole\Http\Server('127.0.0.1',9501, SWOOLE_BASE);
$http->set([
    'log_level' => SWOOLE_LOG_INFO,
    'worker_num' => swoole_cpu_num()
]);
$http->on('request', function (Request $request, Response $response) use ($http) {
    $response->end("Hello Swoole");
});
$http->start();