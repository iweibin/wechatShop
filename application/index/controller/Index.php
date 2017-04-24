<?php
namespace app\index\controller;
use app\index\controller\Base;
use app\index\model\Gimg;
class Index extends Base {

	public function __construct() {
		
	}


	public function index(){
		//$this->auto_login();// 调用微信自动登录
		echo "index";
	}


	public function test() {
		$list = Gimg::get(1);
		var_dump($list);
		echo $list->goods->gname;
	}


}
