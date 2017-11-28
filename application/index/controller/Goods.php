<?php
namespace app\index\controller;
use app\common\controller\HomeBase;
class Goods extends Homebase{

	//列表页
	public function index(){
		
		return $this -> fetch();
	}
}