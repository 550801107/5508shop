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

use app\common\model\Comments;
use think\Cache;
use think\Loader;
use app\common\model\User as UserModel;
use app\common\model\Article as ArticleModel;
use think\Db;
use think\Session;

class UserBase extends HomeBase
{
    protected $user_model;
    protected $article_model;
    protected function _initialize()
    {
        parent::_initialize();
        $this->user_model       = new UserModel();
        $this->article_model    = new ArticleModel();
        //设置个人中心菜单选中状态
        $this->assign('user_index','');
        $this->assign('user_edit','');
        $this->assign('user_msg','');
        $this->assign('user_score','');
        $this->assign('earn_score','');
        $this->assign('user_apply','');
        $this->assign('user_info',$this->GetUserInfo()); //获取用户详情
    }

    /**
     * 获取用户详情
     */
    protected function GetUserInfo($user_id=''){
        $user_id = $user_id?$user_id:UID;
        if(is_numeric($user_id)){
            $where = ['id'=>$user_id];
        }else{
            $where = ['username'=>$user_id];
        }

        $user_info = $this->user_model->where($where)->find();
        return $user_info;
    }

    /**
     * 获取用户发布内容信息
     */
    public function GetUsertopic($user_id,$field='*',$limit='20'){
        $new_topic     =   $this->article_model->
                            where(['author_id'=>$user_id])->
                            limit($limit)->field($field)->
                            order(['id'=>'desc'])->
                            select();
        return $new_topic;
    }
    /**
     * 获取用户最近回复
     */
    public function GetUserComment($user_id,$field='*',$limit='20'){
        $new_comment    =   Comments::where(['user_id'=>$user_id])->limit($limit)->order(['id'=>'desc'])->select();
        foreach($new_comment as $key=>$comment){
            $post_title     =   $this->article_model->where(['id'=>$comment['post_id']])->field(['title'])->find();
            $new_comment[$key]['post_title']    =   $post_title['title'];
        }
        return $new_comment;
    }
    /**
     * 获取用户发布内容信息含分页
     */
    public function GetUsertopicPage($user_id,$field='*',$limit='20',$page){
        $page_topic     =  $this->article_model->
                            where(['author_id'=>$user_id])->
                            limit($limit)->field($field)->
                            order(['id'=>'desc'])->
                            paginate($limit, false, ['page' => $page]);
        return $page_topic;
    }
}