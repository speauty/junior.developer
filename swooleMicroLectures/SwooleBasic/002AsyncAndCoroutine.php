<?php
/**
 * Author:  Speauty
 * Email:   speauty@163.com
 * File:    002AsyncAndCoroutine.php
 * Created: 2019/11/25 下午11:15
 */
/** 本小节由郭新华大佬代讲 */

/**
 * 异步 call_user_func 调用栈 回调地狱 内存空间不能及时释放
 * 协程, 高并发时, 会出现阻塞, 主要是在等待资源, 比如mysql或redis连接池, 所以需要加个熔断器. 当请求达到上限, 主动断掉超出的请求
 */