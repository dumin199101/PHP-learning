<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/7/2
 * Time: 14:51
 */

namespace app\common\model;


use think\Model;

class User extends Model
{
//    protected $table = 'tb_admin';
    protected $name = 'admin';
    //读取器
   protected function getVUsernameAttr($name,$data){
        echo $name . '---'; //属性值
        dump($data); //对象值
        return 1; //返回值
    }
    //修改器
    protected function setVUsernameAttr($name,$data){
        return 2;
    }

    protected function scopeName($query){
        $query->where('v_username','admin');
    }

    //这个方法一定要是public
    public function car(){
        return $this->hasOne('Car','n_user_id','n_id');
    }

    protected function getStatusAttr($val,$data){
         return "Good";
    }
}