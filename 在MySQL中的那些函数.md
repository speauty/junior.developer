## 在MySQL中的那些函数
###### 概要：最近在看《MySQL必知必会》第七章，关于MySQL函数，着实不少，遂摘录于此。因概该书MySQL版本较旧，其中有些函数可能已废，后来有空，再去矫正。

---

* ### 数学函数
| 函数                  | 功能                      |
| --------------------- | ------------------------- |
| DEGREES(x)            | 返回x(弧度)转化为角度的值 |
| RADIANS(x)            | 返回x(角度)转为弧度的值   |
| SIN(x)                | 返回x(弧度)的正弦值       |
| COS(x)                | 返回x(弧度)的余弦值       |
| TAN(x)                | 返回x(弧度)的正切值       |
| COT(x)                | 返回x(弧度)的余切值       |
| ASIN(x)               | 返回x(弧度)的反正弦值     |
| ACOS(x)               | 返回x(弧度)的反余弦值     |
| ATAN(x)               | 返回x(弧度)的反正切值     |
| ABS(x)                | 返回x的绝对值            |
| RAND()                | 返回0到1之间的随机小数值  |
| CEILING(x)            | 返回大于x的最小整数值     |
| FLOOR(x)              | 返回小于x的最大整数值     |
| GREATEST(x1,x2,x3...) | 返回集合中的最大值        |
| LEAST(x1,x2,x3...)    | 返回集合的最小值          |
| EXP(x)                | 返回e(自然对数的底)的x次方 |
| LN(x)                 | 返回x的自然对数           |
| LOG(x,y)              | 返回x的以y为底的对数      |
| POW(x,y)或POWER(x,y)  | 返回x的y次幂             |
| SQRT(x)               | 返回x的开方              |
| MOD(x,y)              | 返回x/y的模              |
| ROUND(x,y)            | 返回x的带有y位小数的值(四舍五入) |
| TRUNCATE(x,y)         | 返回x截短为y位小数的值   |
| PI()                  | 返回圆周率值   |
| SIGN(x)               | 返回代表x符号的值  |
* ### 聚合函数
| 函数                  | 功能                      |
| --------------------- | ------------------------- |
| AVG(col)              | 返回指定列的平均值 |
| COUNT(col)            | 返回指定列的非NULL值的个数 |
| MIN(col)              | 返回指定列的最小值 |
| MAX(col)              | 返回指定列的最大值 |
| SUM(col)              | 返回指定列的所有值之和 |
| STD(col)或STDDEV(col) | 返回指定列的所有值的标准偏差 |
| VARINCE(col)          | 返回指定列的所有值的标准方差 |
| GROUP_CONCAT(col)     | 返回由属于一组的列值连接组合而成的结果 |
* ### 字符串操作函数
| 函数                  | 功能                      |
| --------------------- | ------------------------- |
| ASCII(char)           | 返回字符的ASCII值 |
| REVERSE(str)          | 翻转字符串 |
| STRCMP(s1,s2)         | 比较字符串s1和s2 |
| QUOTE(str)            | 用反斜杠转义str中的单引号 |
| ORD(char)             | 返回字符char的多字节安全编码 |
| BIT_LENGTH(str)       | 返回字符串的bit长度 |
| LENGTH(str)           | 返回字符串的字符个数 |
| LCASE(str)或LOWER(str)| 将str转换为小写 |
| UCASE(str)或UPPER(str)| 将str转换为大写 |
| FIELD(str,s1,s2,s3...)| 分析列表s1,s2,s3...，如果发现str, 则返回str在列表中索引|
| FIND_IN_SET(str, list)| 分析逗号分隔的list列表，如果发现str，则返回str在列表中的位置 |
| CHAR(x1,x2,x3...)     | 返回x1,x2,x3所代表的的ASCII给出的字符组成的字符串 |
| CONCAT(s1,s2,s3...)   | 将s1,s2,s3...连接成字符串 |
| CONCAT_WS(sep,s1,s2,s3...) | 将s1,s2,s3...连接成字符串，并用sep间隔|
| INSERT(str,x,y,instr) | 将字符串str从第x位置开始，y个字符长的字串替换为instr|
| REPLACE(str, searchStr, replaceStr) | 将Str中的searchStr全部替换为replaceStr |
| SUBSTRING(str,x,y)或MID(str,x,y) | 返回从字符串str的x位置起y个字符长度的字串 |
| LEFT(str,x)            | 返回字符串最左边的x个字符 |
| RIGHT(str,x)           | 返回字符串最右边的x个字符 |
| LPAD(str,n,pad)        | 用字符串pad对str进行左填充，直到n个字符长度 |
| RPAD(str,n,pad)        | 用字符串pad对str进行右填充，直到n个字符长度 |
| LTRIM(str)             | 去除字符串左边空格 |
| RTRIM(str)             | 去除字符串右边空格 |
| TRIM(str)              | 去除字符串两端空格 |
| POSITION(substr,str)   | 返回字串substr在str中第一次出现的位置 |
| REPEAT(str, x)         | 返回字符串重复x的值 |
| SPACE(x)               | 生成一个包含x个空格的字符串 |
* ### 日期和时间操作函数
| 函数                  | 功能                      |
| --------------------- | ------------------------- |
| CURDATE()或CURRENT_DATE() | 返回当前日期 |
| YEAR(date)                | 返回date的年份(1000~9999) |
| MONTH(date)               | 返回date的月份值(1~12) |
| MONTHNAME(date)           | 返回date的月份名 |
| QUARTER(date)             | 返回date在一年中的季度(1~4) |
| DATE_FORMAT(date, fmt)    | 按照指定格式fmt格式化日期date |
| DATE_ADD(date, INTERVAL int keyword) | 返回日期加上间隔时间int的值(int必须按照关键字进行格式化) |
| DATE_SUB(date, INTERVAL int keyword) | 返回日期减去间隔时间int的值(int必须按照关键字进行格式化) |
| DAYOFWEEK(date)           | 返回date所代表一星期中的第几天 |
| DAYOFMONTH(date)          | 返回date所代表一个月中的第几天 |
| DAYOFYEAR(date)           | 返回date所代表一年中的第几天 |
| WEEK(date)                | 返回date为一年中的第几周(0~53) |
| DAYNAME(date)             | 返回date的星期名 |
| EXTRACT(keyword FROM date)| 返回date的指定部分，即keyword指定 |
| FROM_DAYS(x)              | 返回一个日期，由年份0加上x天产生的 |
| TO_DAYS(date)             | 返回从0年到date的天数 |
| UNIX_TIMESTAMP(date)      | 返回date所代表的unix时间戳 |
| PERIOD_ADD(date,mon)      | 返回date增加mon月份的结果 |
| PERIOD_DIFF(date1,date2)  | 返回date1和date2相差的月份 |
| CURTIME()或CURRENT_TIME() | 返回当前时间 |
| HOUR(time)                | 返回time的小时值(0~23) |
| MINUTE(time)              | 返回time的分钟值(0~59) |
| SECOND(time)              | 返回time的秒值(0~59) |
| TIME_TO_SEC(time)         | 将时间time转化为秒数 |
| SEC_TO_TIME(x)            | 将秒值x转换为易读的时间值 |
| FROM_UNIXTIME(ts, fmt)    | 根据指定的格式fmt，格式化UNIX时间戳ts |
| TIME_FORMAT(time, fmt)    | 按照指定格式fmt格式化time |
| NOW()                     | 返回当前的日期和时间 |
* ### 数据加密函数
| 函数                  | 功能                      |
| --------------------- | ------------------------- |
| AES_ENCRYPT(str, key) | 返回用秘钥key对st利用高级加密标准算法加密后的值 |
| AES_DECRYPT(str, key) | 返回用秘钥key对st利用高级加密标准算法解密后的值 |
| DECODE(str, key)      | 使用key作为秘钥解密加密字符串str |
| ENCODE(str, salt)     | 使用UNIX crypt()函数，用关键词salt加密字符串str(windows不支持) |
| MD5(str)              | 计算字符串str的MD5校验和 |
| PASSWORD(str)         | 返回str的加密版本 |
| SHA(str)              | 返回str的安全散列算法(SHA)的校验和 |
* ### 控制流函数
| 函数                  | 功能                      |
| --------------------- | ------------------------- |
| CASE WHEN [test] THEN [result] ELSE [default] END | 如果test为真，则返回result，否则返回default |
| CASE [test] WHEN [val] THEN [result] ELSE [default] END | 如果test与val相等，则返回result，否则返回default |
| IF(test, t, f)         | 如果test为真，返回t，否则f |
| IFNULL(arg1,arg2)      | 如果arg1不为空，返回arg1，否则arg2 |
| NULLIF(arg1,arg2)      | 如果arg1=arg2，返回null，否则arg1 |
* ### 格式化函数
| 函数                  | 功能                      |
| --------------------- | ------------------------- |
| DATE_FORMAT(date,fmt) | 按照格式fmt格式化日期date |
| TIME_FORMAT(time,fmt) | 按照格式fmt格式化时间time |
| FORMAT(str, x)        | 把str格式化为逗号隔开的数字序列，保留x位小数|
| INET_ATON(ip)         | 返回IP地址的数字表示 |
| INET_NTOA(num)        | 返回num数字表示的IP |
* ### 类型转化函数
| 函数                  | 功能                      |
| --------------------- | ------------------------- |
| CAST(str AS keyword) | 将str转为keyword类型(BINARY CHAR DATE TIME DATETIME SIGNED UNSIGNED) |
* ### 系统信息函数
| 函数                  | 功能                      |
| --------------------- | ------------------------- |
| DATABASE()            | 返回当前数据库名 |
| BENCHMARK(count,expr) | 将表达式执行count次 |
| CONNECTION_ID()       | 返回当前用户的连接ID |
| FOUND_ROWS()          | 将最后一个select查询(无limit限制)返回的记录行数返回 |
| GET_LOCK(str, dur)    | 获取一个str命令并且有dur秒延时的锁定 |
| IS_FREE_LOCK(str)     | 检查以str命名的锁定是否释放 |
| RELEASE_LOCK(str)     | 释放以str命名的锁定 |
| LAST_INSERT_ID()      | 返回由系统自动产生的最后一个ID |
| MASTER_POS_WAIT(log,pos,dur) | 锁定主服务器dur秒直到从服务器与主服务器的日志log指定的位置pos同步 |
| USER()或SYSTEM_USER() | 返回当前登录用户名 |
| VERSION()             | 返回MySQL服务器版本 |

