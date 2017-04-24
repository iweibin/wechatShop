<?php
namespace app\admin\controller;
use app\admin\controller\Base;

class Index extends Base {

	public function index(){
		
		if( !session('user_admin') ) {
			return $this->fetch('/login');
		} else {
			$this->redirect('Home/index');
		}
		
	}

	
}
