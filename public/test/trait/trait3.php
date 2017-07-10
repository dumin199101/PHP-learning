<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/6/28
 * Time: 10:35
 * Description:解决多个trait之间同名方法或属性的冲突问题
 * Fatal Error:
 * Trait method hello has not been applied, because there are collisions with other trait methods
 * 使用instead of 来解决冲突问题 使用as来引入其它冲突的方法
 */
trait Trait1{
    public function hello()
    {
        echo "Trait1::hello\n";
    }

    public function hi()
    {
        echo "Trait1::hi\n";
    }
}

trait Trait2{
    public function hello()
    {
        echo "Trait2::hello\n";
    }

    public function hi()
    {
        echo "Trait2::hi\n";
    }
}

trait Trait3{
    public function hello()
    {
        echo "Trait3::hello\n";
    }

    public function hi()
    {
        echo "Trait3::hi\n";
    }
}

Class Demo{
//    use Trait1,Trait2;
    use Trait1,Trait2,Trait3{
        Trait1::hello insteadof Trait2,Trait3;
        Trait2::hi insteadof Trait1,Trait3;
    }
}
$demo = new Demo;
$demo->hello();
$demo->hi();

Class Demo2{
    use Trait1,Trait2,Trait3{
        Trait1::hi insteadof Trait2,Trait3;
        Trait1::hello insteadof Trait2,Trait3;
        Trait2::hello as sayTrait2Hello;
        Trait3::hello as sayTrait3Hello;
    }
}

$demo = new Demo2();
$demo->hello();
$demo->sayTrait2Hello();
$demo->sayTrait3Hello();
$demo->hi();