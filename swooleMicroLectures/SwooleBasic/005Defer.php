<?php
/**
 * Author:  Speauty
 * Email:   speauty@163.com
 * File:    005Defer.php
 * Created: 2019/11/26 下午11:31
 */

/** defer必须在协程中使用 */

/*go(function() {
    file_put_contents('/tmp/tmp.tmp', time());
    defer(function() {
        @unlink('/tmp/tmp.tmp');
    });
});*/

/*class DeferTask
{
    private $callback;

    public function __construct(callable $callback)
    {
        $this->callback = $callback;
    }

    public function __destruct()
    {
        $callback = $this->callback;
        $callback();
    }

    public static function make(callable $callback)
    {
        return new static($callback);
    }
}

(function() {
    $dt1 = DeferTask::make(function() {
        echo 'defer task1'.PHP_EOL;
    });
    $dt2 = DeferTask::make(function() {
        echo 'defer task2'.PHP_EOL;
    });
    echo 'func exit'.PHP_EOL;
})();*/

class DeferTask
{
    private $tasks = [];

    public function add(callable $callback) {
        $this->tasks[] = $callback;
    }

    public function __destruct() {
        $tasks = $this->tasks;
        $task = end($tasks);
        do {
            $task();
        } while (($task = prev($tasks)));
    }
}

(function() {
    $defer = new DeferTask();
    $defer->add(function() {
        echo 'defer task1'.PHP_EOL;
    });
    $defer->add(function() {
        echo 'defer task2'.PHP_EOL;
    });
   $defer->add(function() {
        echo 'defer task3'.PHP_EOL;
    });
    echo 'func exit'.PHP_EOL;
})();