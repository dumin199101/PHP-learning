<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/6/28
 * Time: 11:03
 * Description:使用as标示符来改变访问权限
 */
Trait Hello
{
    public function hello(){
        echo "Hello\n";
    }
}

Class Demo{
    use Hello{
        hello as protected;
    }
}

Class Demo2{
    use Hello{
        hello as private hi;
    }
}

//$demo = new Demo();
//$demo->hello();  //Fatal Error 不能访问protected方法

$demo = new Demo2();
$demo->hello(); //这个Hello方法还是公共的
//$demo->hi();  //Fatal Error 不能访问private方法






