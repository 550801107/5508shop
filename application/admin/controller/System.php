<?php
// +----------------------------------------------------------------------
// | ITKEE [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2017 http://www.itkee.cn.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: SuperMan <superman@itkee.cn>
// +----------------------------------------------------------------------
// | 系统管理
// +----------------------------------------------------------------------
namespace app\admin\controller;

use app\common\controller\AdminBase;
use think\Cache;
use think\Db;

/**
 * 系统配置
 * Class System
 * @package app\admin\controller
 */
class System extends AdminBase
{
    public function _initialize()
    {
        parent::_initialize();
    }

    /**
     * 站点配置
     */
    public function siteConfig()
    {
        $system = Db::name('system')->select();
        foreach($system as $key=>$val){
            if(is_serialized($val['value'])){
                $system_value = unserialize($val['value']);
            }else{
                $system_value = $val['value'];
            }
            $this->assign($val['name'],$system_value);
        }
        $theme_css = ['Blue.css','Black.css',];
        $this->assign('data',$theme_css);
        return $this->fetch('site_config');
    }

    /**
     * 更新配置
     */
    public function updateConfig()
    {
        if ($this->request->isPost()) {
            $config_type = $this->request->post('config_type');
            switch ($config_type){
                case 'site_config': //站点配置
                    $site_config                = $this->request->post('site_config/a');
                    $site_config['site_tongji'] = htmlspecialchars_decode($site_config['site_tongji']);
                    $data['value']              = serialize($site_config);
                    break;
                case 'email_config': //邮箱配置
                    $email_config                = $this->request->post('email_config/a');
                    $data['value']              = serialize($email_config);
                    break;
                case 'system_config': //系统项配置
                    $system_config                = $this->request->post('system_config/a');
                    $data['value']                = serialize($system_config);
                    foreach ($system_config as $key=>$val){
                        $system_config[$key] = $val=='true'?true:false;
                    }
                    itkee_set_dynamic_config($system_config);
                    break;
                case 'qq_config':   //QQ登录
                    $qq_config                   = $this->request->post('qq_config/a');
                    $data['value']               = serialize($qq_config);
                    break;
            }
            if(Db::name('system')->where('name', $config_type)->find()){
                if (Db::name('system')->where('name', $config_type)->update($data) !== false) {
                    $this->success('提交成功');
                }else {
                    $this->error('提交失败');
                }
            }else {
                $data['name'] = $config_type;
                if (Db::name('system')->insert($data) !== false) {
                    $this->success('提交成功');
                }else {
                    $this->error('提交失败');
                }
            }
        }
    }

    /**
     * 清除缓存
     */
    public function clear()
    {
        if (delete_dir_file(CACHE_PATH) || delete_dir_file(TEMP_PATH)) {
            $this->success('清除缓存成功');
        } else {
            $this->error('清除缓存失败');
        }
    }
}