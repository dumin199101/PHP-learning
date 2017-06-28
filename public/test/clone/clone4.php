<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/6/28
 * Time: 17:01
 * Description:实现对象属性的深拷贝：序列化方式
 */
class Test{
    public $a = 1;
}

class Test1{
    public $b = 10;
    public $obj;

    public function __construct()
    {
        $this->obj = new Test();
    }
}

$m = new Test1();
$n = unserialize(serialize($m));
$m->b = 100;
echo $n->b . PHP_EOL; //10
$m->obj->a = -1;
echo $n->obj->a . PHP_EOL; //1
