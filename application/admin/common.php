<?php
use think\Db;
/**
 * 获取用户信息
 */
function GetMemberInfo($user_id,$filed='*'){
    $user = Db::name('user')->where(['id'=>$user_id])->field($filed)->find();
    return $user;
}