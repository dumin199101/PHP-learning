<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/6/28
 * Time: 9:56
 * Description:PHP traits 特性
 *             Trait特性是为了解决PHP单继承的局限性，trait可以看成是一个类，但是不能被实例化
 */
trait Hello{
    public $hello = 'Hi Hello';
    public function show(){
        echo 'Hello';
    }
}

trait World{
    public $world = 'Hi World';
    public function show(){
        echo 'World';
    }
}

/**
 *
 * Trait Drive
 */
trait Drive{
    public $carName = 'trait';
    public function driving(){
        echo "driving {$this->carName}\n";
    }
}

class Person{
    public function eat(){
        echo "eat\n";
    }
}

class Student extends Person
{
    //引入trait机制
    use Drive;
    public function study(){
        echo "study\n";
    }
}

//实例化：
$student = new Student();
//调用自身方法：
$student->study();
//调用父类方法：
$student->eat();
//调用trait方法
$student->driving();




