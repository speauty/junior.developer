<?php
/**
 * Author:  Speauty
 * Email:   speauty@163.com
 * File:    InterfaceCar.php
 * Created: 2019/11/21 下午1:18
 */

interface InterfaceCar
{
    public function setWheels(int $num):void;
    public function setWindows(int $num):void;
    public function get(string $type):string;
}