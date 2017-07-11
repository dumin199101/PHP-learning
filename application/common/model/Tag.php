<?php
/**
 * Created by PhpStorm.
 * User: dd
 * Date: 2017/7/10
 * Time: 12:20
 */

namespace app\common\model;


use think\Model;

class Tag extends Model
{
     public function articles(){
         return $this->belongsToMany('Article','ArticleTag','n_article_id','n_tag_id');
     }

}