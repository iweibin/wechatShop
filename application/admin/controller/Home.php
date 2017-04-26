<?php
namespace app\admin\controller;
use app\admin\controller\Base;
use app\admin\model\HomeModel;
use app\admin\model\Goods;


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


		$M = new Goods();
		$goodsList = $M->getGoodsList();



		for ($i=0; $i < count($goodsList); $i++) { 
			$goodsList[$i]['gimg'] = json_decode($goodsList[$i]['gimg'] ,TRUE);

			foreach ($goodsList[$i]['gimg'] as $key => $val) {
				$goodsList[$i]['gimg'][$key] = URL_PATH.'uploads/'.$val;
			}

			$goodsList[$i]['gpri'] = json_decode($goodsList[$i]['gpri'] ,TRUE);
			$goodsList[$i]['gtime'] = date('Y/m/d' ,$goodsList[$i]['gtime']);

		}

		$arr = $M->getGoodsType();
		foreach ($arr as $value) {
			$typeList[$value['gtype_id']] = $value['gtype_name'];
		}


		$this->assign('typeList',$typeList);
		$this->assign('goodsList',$goodsList);
		$this->assign('_controller', 'goodsList');
		return $this->fetch('goodsList');
	}

	public function goodsNew() {

		$M = new Goods();
		$typeList = $M->getGoodsType();

		$this->assign('typeList',$typeList);
		$this->assign('_controller', 'goodsNew');
		return $this->fetch('goodsNew');
	}

	public function goodsNewDo() {
		$data = input('post.');

		$gpri = $data['gpri'];
		$pri_arr = explode("\r\n", trim($gpri));
		foreach ($pri_arr as $value) {
			$arr = explode('/', $value);
			$gpri_arr[$arr[0]] = $arr[1]; 
		}
		$data['gpri'] = json_encode($gpri_arr);
		$data['gimg'] = json_encode($data['gimg']);

		if( $data['sale_mode'] == "2") {
			$data['sale_mode'] = json_encode(array(
				'mode'	=> 2,
				'name'	=> $data['name2']
			));
		} else {
			$data['sale_mode'] = json_encode(array(
				'mode'	=> 1,
				'name'	=> $data['name1']
			));
		}


		unset($data['name1']);
		unset($data['name2']);
		$data['gtime'] = time();

		$M = new Goods();

		if( $M->insertGoods($data) ) {
			echo "<script>alert('添加成功！');window.location.href='".url('home/goodsList')."'</script>";
		} else {
			echo "<script>alert('操作失败，请重试！');window.location.href='".url('home/goodsNew')."'</script>";
		}
	}

	public function goodsEdit( $gid ,$action = '') {

		if( $action != "do" ) {
			$M = new Goods();
			$goodInfo = $M->getGoodByGid($gid);


			$goodInfo['gimg'] = array(
				'img'	=> json_decode($goodInfo['gimg'] ,TRUE),
				'path'	=> URL_PATH.'uploads/'
				);
			
			$goodInfo['gpri'] = json_decode($goodInfo['gpri'] ,TRUE);

			foreach ($goodInfo['gpri'] as $key => $value) {
				$arr1[] = $key.'/'.$value; 
			}
			$goodInfo['gpri'] = implode("\r\n" ,$arr1);

			$goodInfo['sale_mode'] = json_decode($goodInfo['sale_mode'] ,TRUE);

			$goodInfo['gtime'] = date('Y/m/d' ,$goodInfo['gtime']);


			$typeList = $M->getGoodsType();


			$this->assign('typeList',$typeList);
			$this->assign('goodInfo',$goodInfo);
			$this->assign('_controller', 'goodsEdit');
			return $this->fetch('goodsEdit');
		} else {

			$data = input('post.');

			$gpri = $data['gpri'];
			$pri_arr = explode("\r\n", trim($gpri));
			foreach ($pri_arr as $value) {
				$arr = explode('/', $value);
				$gpri_arr[$arr[0]] = $arr[1]; 
			}
			$data['gpri'] = json_encode($gpri_arr);
			$data['gimg'] = json_encode($data['gimg']);

			if( $data['sale_mode'] == "2") {
				$data['sale_mode'] = json_encode(array(
					'mode'	=> 2,
					'name'	=> $data['name2']
				));
			} else {
				$data['sale_mode'] = json_encode(array(
					'mode'	=> 1,
					'name'	=> $data['name1']
				));
			}


			unset($data['name1']);
			unset($data['name2']);

			$M = new Goods();

			if( $M->updateGoods($gid ,$data) ) {
				echo "<script>alert('更新成功！');window.location.href='".url('home/goodsList')."'</script>";
			} else {
				echo "<script>alert('操作失败，请重试！');window.history.go(-1);</script>";
			}
		}
	}

	public function goodsOn( $gid ) {
		$M = new Goods();

		if( $M->updateGoods($gid ,['gstatic'=>1]) ) {
			echo "<script>alert('上架成功！');window.location.href='".url('home/goodsList')."'</script>";
		} else {
			echo "<script>alert('操作失败，请重试！');window.history.go(-1);</script>";
		}
	}

	public function goodsOff( $gid ) {
		$M = new Goods();

		if( $M->updateGoods($gid ,['gstatic'=>0]) ) {
			echo "<script>alert('下架成功！');window.location.href='".url('home/goodsList')."'</script>";
		} else {
			echo "<script>alert('操作失败，请重试！');window.history.go(-1);</script>";
		}	
	}

	public function goodsDel( $gid ) {
		$M = new Goods();

		if( $M->deleteGoods($gid) ) {
			echo "<script>alert('删除成功！');window.location.href='".url('home/goodsList')."'</script>";
		} else {
			echo "<script>alert('操作失败，请重试！');window.history.go(-1);</script>";
		}
	}






	public function test() {
		$pic = array('20170224/pic1.png','20170224/pic2.png','20170224/pic3.png');
		$gpri = array(
			'规格一' => "50.5",
			'规格二' => "100.0",
			'规格三' => "145.0"
			);

		echo json_encode($data);
	}

}
