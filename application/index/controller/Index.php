<?php
// +----------------------------------------------------------------------
// | ITKEE [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2017 http://www.itkee.cn.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: SuperMan <superman@itkee.cn>
// +----------------------------------------------------------------------
// | 首页管理
// +----------------------------------------------------------------------
namespace app\index\controller;
use app\common\controller\HomeBase;

class Index extends HomeBase
{
    protected function _initialize(){
        
        parent::_initialize();
    }

    /**
     * 首页入口
     */
    public function index(){

        return $this->fetch();
    }
}
