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
        'v_username'=>'require|email',
        'v_password'=>'require',
     ];

     protected $message = [
        'v_username.require'=> '用户名不能为空',
        'v_password.require'=> '密码不能为空',
        'v_username.email'=> '用户名必须为邮箱',
     ];
}