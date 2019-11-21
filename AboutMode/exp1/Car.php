<?php
/**
 * Author:  Speauty
 * Email:   speauty@163.com
 * File:    Car.php
 * Created: 2019/11/21 下午1:17
 */

require_once 'InterfaceCar.php';
require_once 'TraitCar.php';

/**
 * Class Car
 * 这是接口配合性状, 集成功能类型
 * 这样处理, 可将一个类中的功能, 进一步, 进行分组抽象集成, 打包, 形成一个比较独立的模块
 */
class Car implements InterfaceCar{use TraitCar;}
/*$car = new Car();
$car->setWheels(7);
$car->setWindows(12);
echo $car->get('wheels');
echo $car->get('windows');*/

/**
 * Class BaseCar
 * 基类, 备用
 */
abstract class BaseCar implements InterfaceCar
{
    protected $car;
    use TraitCar;

    abstract function setCar():void;

    public function car():string
    {
        return $this->get('wheels').' named '.$this->car;
    }
}

/**
 * Class RedCar
 * 产品类 继承基类, 实现静态方法
 */
class RedCar extends BaseCar
{
    function setCar(): void
    {
        $this->car = 'RedCar';
    }
}

/**
 * Class Bentley
 * 同样, 这个也是产品类
 */
class Bentley extends BaseCar
{
    function setCar(): void
    {
        $this->car = 'Bentley';
    }
}

/**
 * Class Client
 * 暴露给外界的类
 */
class Client
{
    public $car;

    /**
     * Client constructor.
     * @param BaseCar $car
     * 其实, 在这里构造函数处理时, 完全可以输入产品类的名称, 独自进行实例化处理
     */
    public function __construct(BaseCar $car)
    {
        $this->car = $car;
        $this->car->setCar();
    }
}

$client = new Client(new Bentley());
$client->car->setWheels(12);
echo $client->car->car();