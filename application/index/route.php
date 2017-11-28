<?php
// +----------------------------------------------------------------------
// | ITKEE [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2017 http://www.itkee.cn.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: SuperMan <superman@itkee.cn>//前台路由
// +----------------------------------------------------------------------
use think\Route;

//首页模块
Route::group(['prefix'=>'index/index/','ext'=>'html'],function(){
    Route::get('/','/index');                   //站点首页
});

return[
	'about' => ['index/page/about',['method' => 'get']], //关于我们
	'message' => 'index/page/message', //留言板
	'goods' =>['index/goods/index',['method'=>'get']], //商品
	];
