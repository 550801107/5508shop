<?php
// +----------------------------------------------------------------------
// | ITKEE [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2017 http://www.itkee.cn.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: SuperMan <superman@itkee.cn>
// +----------------------------------------------------------------------
// | 站点父类控制器
// +----------------------------------------------------------------------
namespace app\common\controller;

use app\common\model\Identity;
use think\Controller;
use think\Cache;

/**
 * 站点父类控制器
 * Class AdminBase
 * @package app\common\controller
 */
class BaseController extends Controller
{
    protected function _initialize()
    {
        parent::_initialize();
    }
}