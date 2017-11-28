<?php
// +----------------------------------------------------------------------
// | ITKEE [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2017 http://www.itkee.cn.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: SuperMan <superman@itkee.cn>
// +----------------------------------------------------------------------
// | USER 模型
// +----------------------------------------------------------------------
namespace app\common\model;

use think\Model;
use think\Session;

class User extends Model
{
    protected $insert = ['id','create_time'];

    /**
     * 创建时间
     * @return bool|string
     */
    protected function setCreateTimeAttr()
    {
        return time();
    }
    protected function getLastLoginTimeAttr($value)
    {
        if($value){
            return date('Y-m-d H:i:s',$value);
        }else{
            return '';
        }
    }
    protected function getIntroAttr($value)
    {
        return $value?$value:'这家伙什么都不说！^_^';
    }

    /**
     * @param $score
     * 用户积分更改
     */
    public function addScore($uid,$score){

        return self::where(['id'=>$uid])->setInc('points',$score); //增加用户积分
    }

    /**
     * QQ登录
     */
    public static function _CallBack($openid,$userinfo){
        if(UID){ //登录状态下，绑定QQ
            return self::qq_bind($openid,$userinfo);
        }else{
            $user = self::where(['qq_openid'=>$openid])->find();
            //第一次登录平台
            if(!$user){
                $data['qq_openid']   = $openid;
                $data['username']    = $userinfo['nickname']; //昵称
                $data['sex']         = $userinfo['gender'];   //性别
                $data['province']    = $userinfo['province']; //省份
                $data['city']        = $userinfo['city'];     //城市
                $data['year']        = $userinfo['year'];     //年龄
                $data['avatar']      = $userinfo['figureurl_qq_2']?$userinfo['figureurl_qq_2']:$userinfo['figureurl_qq_1'];   //头像
                $user_new            = self::create($data);
                Session::set('user_id',$user_new['id']);
                Session::set('user_name', $user_new['username']);
                Session::set('idcard', '0');
                return $user_new;
            }else{ //登录
                Session::set('user_id',$user['id']);
                Session::set('user_name', $user['username']);
                Session::set('idcard', $user['identity_id']);
                return true;
            }
        }
    }
    //绑定QQ
    protected static function qq_bind($openid,$userinfo){
        $update_data['qq_openid']   = $openid;
        $update_data['username']    = $userinfo['nickname']; //昵称
        $update_data['sex']         = $userinfo['gender'];   //性别
        $update_data['province']    = $userinfo['province']; //省份
        $update_data['city']        = $userinfo['city'];     //城市
        $update_data['year']        = $userinfo['year'];     //年龄
        $update_data['avatar']      = $userinfo['figureurl_qq_2']?$userinfo['figureurl_qq_2']:$userinfo['figureurl_qq_1'];   //头像
        $result = self::where(['id'=>UID])->update($update_data);
        return $result;

    }
}