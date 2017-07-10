<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/6/28
 * Time: 11:43
 * Description:PHP对象中的深拷贝跟浅拷贝
 *   深拷贝：相当于值传递，完全拷贝，对其中一个的更改不会影响另一个
 *   浅拷贝：相当于地址传递，取了一个别名，对其中一个更改会影响另一个
 */

//1.值传递：深拷贝
$m = 1;
$n = $m;
$m = 2;
echo "m:{$m}\n";  //2
echo "n:{$n}\n";  //1

//2.对象传递：浅拷贝
class Student{
    public $a = 1;
}

$student1 = new Student();
$student2 = $student1;
$student1->a = 2;
echo "student1:{$student1->a}" . PHP_EOL; //2
echo "student2:{$student2->a}" . PHP_EOL; //2

//3.使用clone实现对象的深拷贝
$student3 = clone $student1;
$student1->a = 3;
echo "student1:{$student1->a}" . PHP_EOL; //3
echo "student3:{$student3->a}" . PHP_EOL; //2

//4.克隆对象时，原对象的普通属性能值复制，但是源对象的对象属性赋值时还是引用赋值，浅拷贝
class Test{
    public $name;
    public function __construct($name)
    {
        $this->name = $name;
    }
    public $a = 1;
}

class Test1{
    public $b = 2;
    public $obj;

    public function __construct($name)
    {
        $this->obj = new Test($name);
    }
}

$m = new Test1("du");
$n = $m;  //这是浅拷贝，无论是普通属性还是对象属性
$m->b = 3;
$m->obj = new Test("min");
echo "$n->b" . PHP_EOL; //3
print_r($n->obj);  //name=>min
echo PHP_EOL;

$m = new Test1("dumin");
$n = clone $m; //普通属性深拷贝，对象属性浅拷贝
$m->b = 100;
echo "$n->b" . PHP_EOL; //2
/*$m->obj->name = "lieyan";
echo $n->obj->name . PHP_EOL;  //lieyan*/
echo str_pad("",100,"--------",STR_PAD_BOTH);
echo PHP_EOL;

$m->obj = new Test1("lieyan");
print_r($n->obj->name); //dumin
echo PHP_EOL;

echo str_pad("",100,"-------------",STR_PAD_BOTH);
















