<?php
/**
 * Author:  Speauty
 * Email:   speauty@163.com
 * File:    TraitCar.php
 * Created: 2019/11/21 下午1:21
 */

trait TraitCar
{
    protected $wheels = 0;
    protected $windows = 0;

    public function setWheels(int $num):void
    {
        $this->wheels = $num;
    }

    public function setWindows(int $num):void
    {
        $this->windows = $num;
    }

    public function get(string $type):string
    {
        $str = 'this part not found from your car';
        if (isset($this->$type)) {
            $str = 'your car has '.$this->$type.' '. $type;
        }
        return $str;
    }
}