#### Securities of Redis

It's Dangerous to use redis with default settings, a website which I developed suffered a attack suspected of redis. So in order to protect your applications from attacks, it's necessary to change the default settings.

Now, here some methods of reducing attacks of redis, if you like, please read completely.

* Creating special user: `sudo useradd -s /bash/false -M redis`
* Setting bind-ip and require-pass
   - opening ip limit: `bind 127.0.0.1`;
   - setting require-pass: `requirepass your-password`;
* Forbidding or Changing some cmd using `rename`
   - exp. `rename-command FLUSHALL ""`;
   - cmd: `FLUSHALL`, `FLUSHDB`, `CONFIG`, `KEYS`, `SHUTDOWN`, `DEL`, `EVAL`;
   - If some cmd renamed, you can use [`rawCommand`](https://github.com/phpredis/phpredis/#rawcommand) to call;
* Changing authorities of conf file
   - Changing code: `sudo chmod 600 redis.conf`;
   - Changing owner: `sudo chown redis redis.conf`;
   - and then restart redis, if breaking with `Can't open the log file: Permission denied`, please to change your log file owner;
   