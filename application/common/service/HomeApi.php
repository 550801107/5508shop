<?php
// +----------------------------------------------------------------------
// | ITKEE [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2017 http://www.itkee.cn.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: SuperMan <superman@itkee.cn>
// +----------------------------------------------------------------------
// | 服务层提供数据接口返回
// +----------------------------------------------------------------------
namespace app\common\service;

use think\Db;
use think\Cache;
class HomeApi
{
    /**
     * 获取站点下载
     */
    public static function GetDownList(){
        $map['is_download'] = 1;
        $download_list = Db::name('article')->where($map)->field(['id','title','introduction','author_id','create_time','reading','comments','thumb'])->limit('20')->select();
        return $download_list;
    }
    /**
     * 获取月度站点pinglun
     */
    public static function GetNewComments(){
        $new_comments = Db::name('comments')->order(['id'=>'desc'])->limit('12')->whereTime('create_time','month')->select();
        return $new_comments;
    }
    /**
     * 获取用户操作配置
     */
    public static function GetUserAction(){
        if (Cache::has('user_action')) {
            $user_action = Cache::get('user_action');
        } else {
            $user_action = Db::name('user_action')->column('score,coin,name', 'action_remark');
            Cache::set('user_action', $user_action);
        }
        return $user_action;
    }

    /**
     * 获取月度站点热门用户
     */
    public static function GetHotUser(){
        if (Cache::has('hot_user')) {
            $hot_user = Cache::get('hot_user');
        } else {
            $hot_user = Db::name('comments')->group('user_id')->field(['count(*)','user_id','user_name'])->order(['count(*)'=>'desc','id'=>'desc'])->limit('12')->whereTime('create_time','month')->select();
            foreach ($hot_user as $key=>$val){
                $hot_user[$key]['avatar']           =   GetAvatar($val['user_id']);
                $hot_user[$key]['user_name']        =   GetMemberInfo($val['user_id'],'username')['username'];
            }
            Cache::set('hot_user', $hot_user);
        }
        return $hot_user;
    }
    /**
     * 获取站点友链
     */
    public static function GetLink(){
        if (Cache::has('link_list')) {
            $link_list = Cache::get('link_list');
        } else {
            $link_list = Db::name('link')->where(['status'=>1])->order(['sort'=>'desc'])->select();
            Cache::set('link_list', $link_list);
        }
        return $link_list;
    }
    /**
     * 获取站点栏目
     */
    public static function GetCategory(){
        if (Cache::has('Category')) {
            $category_list = Cache::get('Category');
        } else {
            $category_list = Db::name('category')->column('name', 'id');
            if (!empty($category_list)) {
                Cache::set('Category', $category_list);
            }
        }
        return $category_list;
    }
    /**
     * 获取站点近期最新贴
     */
    public static function GetHotCommentTopic(){
        if (Cache::has('HotCommentTopic')) {
            $hot_comment_topic = Cache::get('HotCommentTopic');
        } else {
            $hot_comment_topic = Db::name('article')->
            where(['status' => 1])->
            whereTime('create_time','month')->
            field(['id', 'title', 'author', 'author_id', 'reading', 'publish_time', 'cid', 'is_top', 'is_hot', 'comments'])->
            limit('15')->
            order(['comments' => 'desc','id' => 'desc'])->
            select();
            if (!empty($hot_comment_topic)) {
                Cache::set('HotCommentTopic', $hot_comment_topic);
            }
        }
        return $hot_comment_topic;
    }
    /**
     * 获取站点加精文章
     */
    public static function GetHotTopPic($limit='15'){
        if (Cache::has('Hottopic')) {
            $hot_topic = Cache::get('Hottopic');
        } else {
            $hot_topic = Db::name('article')->
            where(['status' => 1,'is_hot'=>'1'])->
            field(['id','title','author','author_id','reading','publish_time','cid','is_top','is_hot','comments'])->
            limit($limit)->
            order(['sort' => 'ASC','id'=>'desc'])->
            select();
            if (!empty($hot_topic)) {
                Cache::set('Hottopic', $hot_topic);
            }
        }
        return $hot_topic;
    }
    /**
     * 获取站点置顶文章
     */
    public static function GetTopicTop($limit='15'){
        if (Cache::has('Toptopic')) {
            $top_topic = Cache::get('Toptopic');
        } else {
            $top_topic = Db::name('article')->
            where(['status' => 1,'is_top'=>'1'])->
            field(['id','title','author','author_id','reading','publish_time','cid','is_top','is_hot','comments'])->
            limit($limit)->
            order(['is_hot' => 'desc','sort' => 'desc','id'=>'desc'])->
            select();
            if (!empty($top_topic)) {
                Cache::set('Toptopic', $top_topic);
            }
        }
        return $top_topic;
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
        return Cache::get('site_config');
    }
    /**
     * 获取前端公告
     */
    public static function GetNotice($limit=''){
        if (Cache::has('notice_list')) {
            $notice_list = Cache::get('notice_list');
        } else {
            $notice_list = Db::name('notice')->where(['status' => 1])->order(['sort' => 'DESC','id'=>'desc'])->limit($limit)->select();
            if (!empty($notice_list)) {
                Cache::set('notice_list', $notice_list);
            }
        }
        return $notice_list;
    }
    /**
     * 获取前端导航列表
     */
    public static function GetNav(){
        $navs = [];
        if (Cache::has('navs')) {
            $navs = Cache::get('navs');
        } else {
            $nav = Db::name('nav')->where(['status' => 1])->order(['sort' => 'ASC'])->select();
            $nav = !empty($nav) ? list_to_tree($nav,'id','pid','children') : [];
            //导航分类重组
            foreach ($nav as $key=>$val){
                $navs[$val['nav_cid']][$key] = $val;
            }
            if (!empty($navs)) {
                Cache::set('navs', $navs);
            }
        }
        return $navs;
    }
    /**
     * 获取前端轮播图
     */
    public static function GetSlide()
    {
        $slides = [];
        if (Cache::has('slides')) {
            $slides = Cache::get('slides');
        } else {
            $slide = Db::name('slide')->where(['status' => 1])->order(['sort' => 'DESC'])->select();

        if (!empty($slide)) {
                Cache::set('slide', $slide);
            }
            //轮播分类重组
            foreach ($slide as $key => $val) {
                $slides[$val['cid']][$key] = $val;
            }
            if (!empty($slides)) {
                Cache::set('slides', $slides);
            }
        }
        return $slides;
    }
}