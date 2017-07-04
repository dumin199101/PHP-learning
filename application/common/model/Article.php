<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/7/2
 * Time: 22:01
 */

namespace app\common\model;


use think\Model;

class Article extends Model
{
    protected $table = 'tb_article';

    //读取或写入时类型转换
    protected $type = [
        'n_create_time' => 'timestamp:Y-m-d' //插入时转换为timestamp,读取时转换为date
    ];

    //自动完成
    protected $auto = [
        'n_user_id' => 1,
        'n_cat_id' => 2,
        'n_isrecycle',
    ];

    protected function setNIsrecycleAttr($val, $data)
    {
        return 2;
    }
}