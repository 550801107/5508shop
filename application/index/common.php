<?php
/**
 * 前台公共函数库
 * @Author SuperMan
 */

/**
 * @param $user_id
 * 获取用户头像
 */
function GetAvatar($user_id){
    $user = \app\common\model\User::where(['id'=>$user_id])->field(['avatar'])->find();
    if($user['avatar']){
        return  $user['avatar'];
    }else{
        return '__STATIC__/images/default_head.png';
    }
}

/**
 * 获取文章信息
 */
function GettopicInfo($id,$filed='*'){
    $topic =   \app\common\model\Article::where(['id'=>$id])->field($filed)->find();
    return $topic;
}
/**
 * 获取用户信息
 */
function GetMemberInfo($user_id,$filed='*'){
    $user = \app\common\model\User::where(['id'=>$user_id])->field($filed)->find();
    return $user;
}
