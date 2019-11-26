<?php
/**
 * Author:  Speauty
 * Email:   speauty@163.com
 * File:    008Channel.php
 * Created: 2019/11/26 下午11:12
 */

use \Swoole\Coroutine;
use \Swoole\Coroutine\Channel;

Coroutine::create(function() {
    $channel = new Channel();

    Coroutine::create(function() use ($channel) {
        $addrInfo = Coroutine::getAddrInfo('github.com');
        $channel->push(['A', json_encode($addrInfo)]);
    });

    Coroutine::create(function() use ($channel) {
        $mirror = Coroutine::readFile(__FILE__);
        $channel->push(['B', $mirror]);
    });

    Coroutine::create(function() use ($channel) {
        $channel->push(['C', date(DATE_W3C)]);
    });

    for ($i = 3; $i--;) {
        /** $channel->pop() 获取协程返回值 */
        list($id, $data) = $channel->pop();
        echo "From {$id}: \n{$data}\n";
    }

    /**
     * channel
     * push 生产者
     * pop 消费者
     */
});