<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/7/5
 * Time: 21:16
 */

namespace app\index\validate;

use think\Validate;

class Admin extends Validate
{
     protected $rule = [
        'v_username'=>'require|email|checkUsername:lieyan',
        'v_password'=>'require',
     ];

     protected $message = [
        'v_username.require'=> '用户名不能为空',
        'v_password.require'=> '密码不能为空',
        'v_username.email'=> '用户名必须为邮箱',
        'v_username.checkUsername'=>'用户名必须包含lieyan'
     ];

     //自定义校验规则：
     /**
      * @param $val 输入值
      * @param $rule 验证规则
      */
     protected function checkUsername($val,$rule){
          if(strrpos($val,$rule)!==FALSE){
               return true;
          }
          return false;
     }
}