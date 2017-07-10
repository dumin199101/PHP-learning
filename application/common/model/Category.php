<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/7/6
 * Time: 21:16
 */

namespace app\common\model;
use think\Model;


class Category extends Model
{
    protected $table = 'tb_category';

    /**
     * 获取分类下的相关文章：
     */
    public function article(){
        return $this->hasMany('Article','n_cat_id','n_id');
    }
}