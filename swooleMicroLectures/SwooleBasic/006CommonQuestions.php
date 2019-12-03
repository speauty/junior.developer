<?php
/**
 * Author:  Speauty
 * Email:   speauty@163.com
 * File:    006commonQuestions.php
 * Created: 2019/12/2 下午7:23
 */

/**
 * 常见问题盘点01
 * 1. 学习swoole所需基础知识: 学好php, linux网络编程
 * 2. 出现问题时先升级swoole版本
 * 3. 如果将老项目无缝迁移至Swoole:
 * * fpm开发模式滥用全局变量和静态变量
 * * 选择专属框架比魔改旧框架更好
 * * 小项目可以使用Runtime Hook
 * 4. 升级版本后coredump
 * * 没有make clean清理
 * * 使用`pecl upgrade`可以忽略此问题
 * * 不要使用非release版本
 * * 不要开启实验性的编译选项
 * 5. 连接已关闭问题: 客户端没有等待服务响应, 导致服务发送到客户端, 就会检测客户端已关闭
 */
