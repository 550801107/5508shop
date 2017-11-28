<?php
// +----------------------------------------------------------------------
// | ITKEE [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2017 http://www.itkee.cn.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: SuperMan <superman@itkee.cn>
// +----------------------------------------------------------------------
namespace app\admin\controller;

use app\common\controller\AdminBase;
use think\Cookie;
use think\Db;
use think\Request;
use think\Cache;
use think\Session;

/**
 * 清理缓存
 * Class Clear
 * @package app\admin\controller
 */
class Clear extends AdminBase
{
    public function __construct(Request $request = null)
    {
        parent::__construct($request);
    }
    //清空缓存
    public function delete(){

        if(Cache::clear()){
            return $this -> success('清理成功');
            // return json(['code' => '1','msg' => '清理成功']);
        }else{
            // return json(['code' => '0','msg' => '清理失败']);
            return $this->error('清理失败');
        }
    }

}
