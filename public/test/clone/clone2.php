<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/6/28
 * Time: 12:16
 */
class Test{
    public $a=1;
}

class TestOne{
    public $b=1;
    public $obj;
    //包含了一个对象属性，clone时，它会是浅拷贝
    public function __construct(){
        $this->obj = new Test();
    }
}
$m = new TestOne();
$n = $m;//这是完全的浅拷贝，无论普通属性还是对象属性

$p = clone $m;

//普通属性实现了深拷贝，改变普通属性b，不会对源对象有影响
$p->b = 2;
echo $m->b;//输出原来的1
echo PHP_EOL;

//对象属性是浅拷贝，改变对象属性中的a，源对象m中的对象属性中a也改变

$p->obj->a = 3;
echo $m->obj->a;//输出3，随新对象改变
echo PHP_EOL;