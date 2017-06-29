<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/6/28
 * Time: 11:11
 * Description:trait结合静态方法，静态属性，抽象方法
 */
trait Hello{
    public function sayHello()
    {
        echo "say Hello\n";
    }
}

trait World{
    //Trait嵌套：
    use Hello;
    //成员方法
    public function sayWorld()
    {
        echo "say World\n";
    }
    //抽象方法
    abstract public function getWorld();
    //静态方法：
    public static function doSomething(){
        echo "do Something\n";
    }

    public function incr(){
        //静态属性
        static $i = 0;
        $i++;
        echo "$i\n";
    }

}

class HelloWorld{
    use World;
    //重写抽象方法
    public function getWorld()
    {
        // TODO: Implement getWorld() method.
        echo "Hello World\n";
    }
}

//测试：
$helloworld = new HelloWorld();
//调用抽象方法
$helloworld->getWorld();
//调用静态方法
$helloworld::doSomething();
//调用trait中的方法
$helloworld->sayWorld();
$helloworld->sayHello();
//调用静态属性
$helloworld->incr();
$helloworld->incr();
