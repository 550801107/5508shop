<?php
namespace app\common\model;

use think\Db;
use think\Model;

class Identity extends Model
{
    protected $insert = ['create_time'];
    /**
     * 创建时间
     * @return bool|string
     */
    protected function setCreateTimeAttr()
    {
        return time();
    }
}