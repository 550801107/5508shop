<?php
namespace app\index\controller;
use app\common\controller\HomeBase;
use \think\Request;

class Page extends HomeBase{

	//关于我们单页面
	public function about(){

		return $this -> fetch();
	}

	//留言板页面
	public function message(){

		if(request()->isPost()){

			$data = [
				'message' => input('message'),
				'firstname' => input('firstname'),
				'lastname' => input('lastname'),
				'address' => input('address'),
				'message' => input('message')
			];
			echo "<pre/>";
			print_r($data);exit;
		}

		return $this -> fetch();
	}
}