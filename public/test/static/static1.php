<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/6/28
 * Time: 11:27
 * Description:PHP中的后期静态延迟绑定：self取决于定义时的类而不是运行时所在的类
 */
class Person{
    public static function status()
    {
//        self::getStatus();
        static::getStatus();
    }

    protected function getStatus(){
        echo "Person getStatus\n";
    }
}

class Student extends Person{
    public function getStatus()
    {
        echo "Student getStatus\n";
    }
}
$student = new Student();
//$student->status(); //输出的是Person getStatus
$student->status(); //输出的是Student getStatus
