<?php
/**
 * Author:  Speauty
 * Email:   speauty@163.com
 * File:    HttpService.php
 * Created: 2019/11/25 下午11:30
 */
use Swoole\Http\Request;
use Swoole\Http\Response;

$process = new Swoole\Process(function(Swoole\Process $process) {
    $server = new Swoole\Http\Server('127.0.0.1',9501, SWOOLE_BASE);
    $server->set([
        'log_file' => '/dev/null',
        'log_level' => SWOOLE_LOG_INFO,
        'worker_num' => swoole_cpu_num()*2,
        'hook_flag' => SWOOLE_HOOK_ALL /** 将php所有同步阻塞函数方法替换成异步非阻塞的协程调度的 */
    ]);
    $server->on('workerStart', function() use ($process, $server) {
//        $server->pool = new RedisQueue();
        $server->pool = new RedisPool(64);
        $process->write("1");
    });
    $server->on('request', function (Request $request, Response $response) use ($server) {
        try {
            /*$redis = new Redis();
            $redis->connect('127.0.0.1', 5867);
            $redis->auth('bug@cO0O');*/
            $redis = $server->pool->get();
            $greeter = $redis->get('greeter');
            if (!$greeter) {
                throw new RedisException('get data failed');
            }
            $server->pool->put($redis);
            $response->end("<h1>{$greeter}</h1>");
        } catch (\Throwable $e) {
            $response->status(500);
            $response->end();
        }
    });
    $server->start();
});
if ($process->start()) {
    register_shutdown_function(function () use ($process) {
        $process::kill($process->pid);
        $process::wait();
    });
    $process->read(1);
    System('ab -c 25 -n 100 -k http://127.0.0.1:9501/ 2>&1');
}

class RedisQueue
{
    protected $pool;

    public function __construct()
    {
        $this->pool = new SplQueue();
    }

    public function get(): Redis
    {
        /** 当高并发时, 瞬时生成Redis连接过多, 同样会崩掉 */
        if ($this->pool->isEmpty()) {
            $redis = new Redis();
            $redis->connect('127.0.0.1', 5867);
            $redis->auth('bug@cO0O');
            return $redis;
        }
        return $this->pool->dequeue();
    }

    public function put(Redis $redis)
    {
        $this->pool->enqueue($redis);
    }

    public function close():void
    {
        $this->pool = null;
    }
}

class RedisPool
{
    protected $pool;

    public function __construct(int $size)
    {
        /** 启动时, 可能有点慢 */
        $this->pool = new \Swoole\Coroutine\Channel($size);
        for ($i = 0; $i < $size; ++$i) {
            while (true) {
                try {
                    $redis = new Redis();
                    $redis->connect('127.0.0.1', 5867);
                    $redis->auth('bug@cO0O');
                    $this->put($redis);
                    break;
                } catch (\Throwable $e) {
                    usleep(1000);
                    continue;
                }
            }
        }
    }

    public function get():Redis
    {
        /** 如果该通道内, 没有redis资源, 协程会被挂起, 等有资源被回收后, 才能继续取出 */
        return $this->pool->pop();
    }

    public function put(Redis $redis)
    {
        $this->pool->push($redis);
    }

    public function close():void
    {
        $this->pool->close();
        $this->pool = null;
    }
}
