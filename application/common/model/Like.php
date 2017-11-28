<?php
namespace app\common\model;

use think\Db;
use think\Model;

class Like extends Model
{
    protected $insert   =   ['create_time'];
    protected function setCreateTimeAttr(){
        return time();
    }
}