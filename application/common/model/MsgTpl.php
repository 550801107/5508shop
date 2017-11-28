<?php
namespace app\common\model;

use think\Db;
use think\Model;

class MsgTpl extends Model
{

    /**
     * @param $remark
     * 获取模板详情
     */
    public static function GetTplInfo($remark){
        $tpl = self::get(['remark'=>$remark]);
        return $tpl;
    }
}