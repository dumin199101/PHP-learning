<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/6/28
 * Time: 10:14
 * Description: trait的优先级：本类覆盖trait，trait覆盖父类，可以同时引入多个trait用，分隔
 */
trait Drive{
    public function hello()
    {
        echo "hello drive\n";
    }

    public function driving()
    {
        echo "driving from drive\n";
    }
}

class Person{
    public function hello()
    {
        echo "hello person\n";
    }

    public function driving()
    {
        echo "driving from person\n";
    }
}

class Student extends Person{
    use Drive;
    public function hello()
    {
        echo "hello Student\n";
    }
}

//实例化：
$student = new Student;
$student->hello();  //hello Student
$student->driving();  //driving from drive
