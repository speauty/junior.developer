### PHP强制模式解读

##### 语法是这样的: `declare(strict_types=1);`, 需要放在PHP脚本文件其他输出之前最先声明的位置.否则会报以下致命语法错误:
```
> # strict_types.php
<?php
echo 2;
declare(stric_types=1);

> PHP Fatal error:  strict_types declaration must be the very first statement in the script in /home/speauty/strict_types.php on line 3
```

##### 那么, 在申明了强制模式后, 需要注意的是:
1. ##### `strict_types` 只会影响当前申明的文件, 其中并不包含引入的文件.
2. ##### 原理是通过在 `opcode` 中设置一个标志位，让函数调用和返回类型检查符合类型约束.
3. ##### `strict_types` 主要包含有下面几种类型参数: `string`, `int`, `float` 和 `bool` 等其他类型, PHP7扩展了 `类名,接口,数组和回调类型` .

##### 现在测试一下第二条注意事项, `vim strict_types.php`
```
<?php
declare(strict_types=1);
function test(int $num)
{
    return $num;
}
test('test');
```
```
> php strict_types.php
> PHP Fatal error:  Uncaught TypeError: Argument 1 passed to test() must be of the type int, string given
> # 大意就是该函数第一个参数必须为整型, 而调用函数接收到是字符串类型.
```

##### 上例是强调了参数类型, 我们再来看下函数返回值类型的限制. 这也是PHP7的新特性之一 `返回值类型声明`.
```
<?php
declare(strict_types=1);
function test(int $num):string
{
    return $num;
}
test(78);
```
```
> php strict_types.php
> PHP Fatal error:  Uncaught TypeError: Return value of test() must be of the type string, int returned
> # 还是差不多, 不过是强调了函数的返回值类型必须要与指定类型保持, 否则就会导致致命错误, 致使脚本执行中断.
> # 估计是在转换成字节码后进行语法分析, 确定的错误. 
```

##### 这种强制类型意味着什么? 由于类型的确定, 在变量进行计算时, 不需要进行额外的类型隐式转换开销, 而且也对程序的健壮性有一定影响, 还是因为确定的类型.
##### 类似 `C语言`, 函数的参数和返回值都有固定的类型声明, 如果PHP这边, 再将变量也整个类型声明, 至少在表面上, 看起来就差不多了.
##### 不过由于强制模式的规范, 会对函数或方法的编写更为严格, 才能符合其名, 否则, 强制类型似乎也是空谈.其实也还是看个人的. 如果没有声明, 似乎也还是可以调用的.
##### 说到底, 强制模式并不'强制', 最终, 还是取决于写代码的人. 我所理解的'强制'应该是无条件的必须, 就像 `Python` 的空格标志.
##### 关于强制模式的理解和笔记, 大概就这些, 后续有什么新的发现, 再做补充.


