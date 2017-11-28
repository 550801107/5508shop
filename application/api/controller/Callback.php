<?php
// +----------------------------------------------------------------------
// | ITKEE [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2017 http://www.itkee.cn.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: SuperMan <superman@itkee.cn>
// +----------------------------------------------------------------------
// | QQ登录回调控制器
// +----------------------------------------------------------------------
namespace app\api\controller;
use app\common\controller\HomeBase;
use app\common\model\User;
use think\Cache;
use think\Config;


/**
 * 会员接口
 * Class User
 * @package app\api\controller
 */
class Callback extends HomeBase
{
    public function _initialize(){
        //配置文件
        header('Content-Type: text/html; charset=UTF-8');
        $QQ_CONFIG          = Cache::get('qq_config');
        $this->qq_k         = $QQ_CONFIG['app_id']; //QQ应用APP ID
        $this->qq_s         = $QQ_CONFIG['app_key']; //QQ应用APP KEY
        $this->callback_url = $QQ_CONFIG['call_back']; //授权回调网址
        $this->scope='get_user_info,add_share'; //权限列表，具体权限请查看官方的api文档
        parent::_initialize();
    }

    /**
     * qq_back
     */
    public function qq_back(){
        vendor('qq');
        if(isset($_GET['code']) && trim($_GET['code'])!=''){
            $qq=new \qqPHP($this->qq_k, $this->qq_s);
            $result=$qq->access_token($this->callback_url, $_GET['code']);
            if(isset($result['access_token']) && $result['access_token']!=''){
                //保存登录信息
                $qq         =   new \qqPHP($this->qq_k, $this->qq_s,$result['access_token']);
                $qq_oid     =   $qq->get_openid();
                $openid     =   $qq_oid['openid']; //获取登录用户open id
                $userinfo   =   $qq->get_user_info($openid);//获取登录用户信息
                $result = User::_CallBack($openid,$userinfo);
                if($result){
                    $this->redirect('/user-set.html');
                }else{
                    $this->error('登录失败');
                }
            }else{
                $this->error('授权失败');
            }
        }else{
            $this->error('授权失败');
        }
    }
    /**
     * 取消绑定
     */
    public function qq_unbind(){
        $update_data['qq_openid']   = '';
        $result = User::where(['id'=>UID])->update($update_data);
        if($result){
            $this->success('操作成功');
        }else{
            $this->error('操作失败');
        }
    }

    /**
     * QQ
     */
    public function qq_connect(){
        vendor('qq');
        //生成登录链接
        $qq=new \qqPHP($this->qq_k, $this->qq_s);
        $login_url=$qq->login_url($this->callback_url, $this->scope);
        return $this->redirect($login_url);
    }


}