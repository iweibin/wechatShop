<?php
namespace app\admin\controller;
use app\admin\controller\Base;
use app\admin\model\HomeModel;
class Home extends Base {

	public function __construct() {
		parent::__construct();

		$this->checkLogin();
	}

	public function index(){
		//$this->auto_login();

		$this->assign('_controller', 'index');
		return $this->fetch('/home');
	}

	public function userList() {

		$M = new HomeModel();

		$userList = $M->getUserList();

		$this->assign('userList',$userList);
		$this->assign('_controller', 'userList');

		return $this->fetch('userList');
	}


	public function userDel( $uid = '') {

		$M = new HomeModel();

		if( $M->userDel($uid) ) {
			echo "<script>alert('删除成功！');window.location.href='".url('home/userList')."'</script>";
		} else {
			echo "<script>alert('操作失败，请重试！');window.location.href='".url('home/userList')."'</script>";
		}
	}


	public function orderList() {


		$this->assign('orderList',null);
		$this->assign('_controller', 'orderList');
		return $this->fetch('orderList');
	}



	public function goodsList() {

	}

	public function goodsNew() {

		$this->assign('_controller', 'goodsNew');
		return $this->fetch('goodsNew');
	}

	public function goodsNewDo() {
		var_dump($_POST);
	}
	public function goodsCategory() {
		
	}

}
