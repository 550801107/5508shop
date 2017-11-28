<?php
// +----------------------------------------------------------------------
// | ITKEE [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2017 http://www.itkee.cn.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: SuperMan <superman@itkee.cn>
// +----------------------------------------------------------------------
// | 前台父类
// +----------------------------------------------------------------------
namespace app\common\controller;

use app\common\service\HomeApi;
use think\Cache;
use think\Db;
use think\Loader;

class HomeBase extends BaseController
{
    protected $category_model;
    protected function _initialize()
    {
        parent::_initialize();
        $this->GetSiteSystem();
        $site_config = Cache::get('site_config');
        $this->assign($site_config);
    }

    /**
     * 获取站点配置信息
     */
    public static function GetSiteSystem(){
        if(!Cache::get('site_config')){
            if (Cache::has('system_config')) {
                $system_config = Cache::get('system_config');
            } else {
                $system_config = Db::name('system')->select();
                Cache::set('system_config', $system_config);
            }
            foreach($system_config as $key=>$val){
                if(is_serialized($val['value'])){
                    $system_value = unserialize($val['value']);
                }else{
                    $system_value = $val['value'];
                }
                if(!Cache::get($val['name'])){  Cache::set($val['name'], $system_value);}
            }
        }
    }
}