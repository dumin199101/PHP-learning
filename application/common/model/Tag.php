<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/7/10
 * Time: 22:08
 */

namespace app\common\model;


use think\Model;

class Tag extends Model
{
    public function articles()
    {
        return $this->belongsToMany('Article','article_tag','n_article_id','n_tag_id');
    }
}