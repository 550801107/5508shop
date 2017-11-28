<?php
namespace app\common\model;

use think\Db;
use think\Model;

class Keyword extends Model
{
    /**
     * @param $keywords
     * 更新关键字
     */
    public static function addKey($keywords){
        if(self::get(['keyword'=>$keywords])){
            self::where(['keyword'=>$keywords])->setInc('count');
        }else{
            self::insert(['keyword'=>$keywords]);
        }
    }
}