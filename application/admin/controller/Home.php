<?php
namespace app\admin\controller;
use app\admin\controller\Base;
use app\admin\model\User;
use app\admin\model\HomeModel;
use app\admin\model\Goods;
use app\admin\model\Master;
use app\admin\model\Works;


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

	public function profile($action = '') {

		if($action == '' ) {
			$logined = session('user_admin');

			$M = new User();
			$admin = $M->getUserInfo($logined['username']);

			$this->assign('profile' ,$admin);
			$this->assign('_controller', 'profile');
			return $this->fetch('profile');
		} else {

			$data = input('post.');

			$username = $data['username'];

			$M = new User();

			if( $data['password'] == '') {
				unset($data['password']);
			} else {
				$info = $M->getUserInfo($username);
				$data['password'] = md5(md5($data['password']).$info['user_key']);
			}


			if($M->update_info($username ,$data)) {
				echo "<script>alert('修改成功！');window.location.href='".url('home/index')."'</script>";
			} else {
				echo "<script>alert('操作失败，请重试！');window.history.go(-1);</script>";
			}
		}
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
			echo "<script>alert('操作失败，请重试！');window.history.go(-1);</script>";
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
			echo "<script>alert('操作失败，请重试！');window.history.go(-1);</script>";
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

	public function masterList() {

		$M = new Master();

		$masterList = $M->getMasterList();

		for ($i=0; $i < count($masterList); $i++) { 
			$masterList[$i]['master_works'] = count($M->getWorksById($masterList[$i]['master_id']));
		}


		$this->assign('masterList',$masterList);
		$this->assign('_controller','masterList');
		return $this->fetch('masterList');
	}


	public function masterNew( $action = '') {

		if( $action == '') {

			$this->assign('_controller','masterNew');
			return $this->fetch('masterNew');
		} else {
			$data = input('post.');

			// 获取表单上传文件 例如上传了001.jpg
		    $file = request()->file('master_picture');
		    // 移动到框架应用根目录/public/uploads/ 目录下
		    $info = $file->validate(['size'=>1024*1024*10,'ext'=>'jpg,png,gif,bmp,jpeg'])->move(ROOT_PATH . 'public' . DS . 'uploads');
		    if( $info ) {
		    	$data['master_picture'] = $info->getSaveName();
		    }

		    $M = new Master();

		    if( $M->insertMaster($data) ) {
		    	echo "<script>alert('添加成功！');window.location.href='".url('home/masterList')."'</script>";
		    }
		}

	}

	public function masterEdit( $mid ,$action = '' ) {
		if( $action == '' ) {

			$M = new Master();

			$master = $M->getMasterInfo($mid);

			$master['master_picture'] = URL_PATH.'uploads/'.$master['master_picture'];

			// var_dump($master);exit;
			$this->assign('master' ,$master);
			$this->assign('_controller' ,'masterEdit');
			return $this->fetch('masterEdit');
		} else {
			$data = input('post.');

			// 获取表单上传文件 例如上传了001.jpg
		    $file = request()->file('master_picture');
		    // 移动到框架应用根目录/public/uploads/ 目录下
		    $info = $file->validate(['size'=>1024*1024*10,'ext'=>'jpg,png,gif,bmp,jpeg'])->move(ROOT_PATH . 'public' . DS . 'uploads');
		    if( $info ) {
		    	$data['master_picture'] = $info->getSaveName();
		    }

		    $M = new Master();

		    if( $M->updateMaster($mid,$data) ) {
		    	echo "<script>alert('修改成功！');window.location.href='".url('home/masterList')."'</script>";
		    } else {
		    	echo "<script>alert('操作失败，请重试！');window.history.go(-1);</script>";
		    }
		}
	}

	public function masterDel( $mid ) {
		$M = new Master();

		if( $M->deleteMaster($mid) ) {
			echo "<script>alert('删除成功！');window.location.href='".url('home/masterList')."'</script>";
		} else {
			echo "<script>alert('操作失败，请重试！');window.history.go(-1);</script>";
		}
	}


	public function workList() {

		$M = new Works();
		$workList = $M->getWorkList();

		for ($i=0; $i < count($workList); $i++) { 
			$workList[$i]['works_pic'] = json_decode($workList[$i]['works_pic'] ,TRUE);

			foreach ($workList[$i]['works_pic'] as $key => $val) {
				$workList[$i]['works_pic'][$key] = URL_PATH.'uploads/'.$val;
			}

			$workList[$i]['works_prize'] = json_decode($workList[$i]['works_prize'] ,TRUE);
			$workList[$i]['time'] = date('Y/m/d' ,$workList[$i]['time']);

		}
		$this->assign('workList' ,$workList);

		$this->assign('_controller' ,'workList');
		return $this->fetch('workList');
	}

	public function workNew( $action = '' ) {

		if( $action == '' ) {
			$M = new Master();

			$nameList = $M->getNameList();

			$this->assign('nameList' ,$nameList);
			$this->assign('_controller' ,'workNew');
			return $this->fetch('workNew');
		} else {

			$data = input('post.');

			$gpri = $data['works_prize'];
			$pri_arr = explode("\r\n", trim($gpri));
			foreach ($pri_arr as $value) {
				$arr = explode('/', $value);
				$gpri_arr[$arr[0]] = $arr[1]; 
			}
			$data['works_prize'] = json_encode($gpri_arr);
			$data['works_pic'] = json_encode($data['gimg']);

			unset($data['gimg']);
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
			$data['time'] = time();

			$M = new Works();

			if( $M->insertWorks($data) ) {
				echo "<script>alert('添加成功！');window.location.href='".url('home/workList')."'</script>";
			} else {
				echo "<script>alert('操作失败，请重试！');window.history.go(-1);</script>";
			}	
		}
	}

	public function workEdit( $wid ,$action = '') {

		if( $action == "" ) {
			$M = new Works();
			$workInfo = $M->getWorkByid($wid);


			$workInfo['works_pic'] = array(
				'img'	=> json_decode($workInfo['works_pic'] ,TRUE),
				'path'	=> URL_PATH.'uploads/'
				);
			
			$workInfo['works_prize'] = json_decode($workInfo['works_prize'] ,TRUE);

			foreach ($workInfo['works_prize'] as $key => $value) {
				$arr1[] = $key.'/'.$value; 
			}
			$workInfo['works_prize'] = implode("\r\n" ,$arr1);

			$workInfo['sale_mode'] = json_decode($workInfo['sale_mode'] ,TRUE);

			$workInfo['time'] = date('Y/m/d' ,$workInfo['time']);

			$M = new Master();
			$nameList = $M->getNameList();
			$this->assign('nameList' ,$nameList);
			// var_dump($workInfo);exit;
			$this->assign('workInfo',$workInfo);
			$this->assign('_controller', 'workEdit');
			return $this->fetch('workEdit');
		} else {

			$data = input('post.');

			$gpri = $data['works_prize'];
			$pri_arr = explode("\r\n", trim($gpri));
			foreach ($pri_arr as $value) {
				$arr = explode('/', $value);
				$gpri_arr[$arr[0]] = $arr[1]; 
			}
			$data['works_prize'] = json_encode($gpri_arr);
			$data['works_pic'] = json_encode($data['gimg']);

			unset($data['gimg']);
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
			$data['time'] = time();

			$M = new Works();

			if( $M->updateWork( $wid ,$data) ) {
				echo "<script>alert('更新成功！');window.location.href='".url('home/workList')."'</script>";
			} else {
				echo "<script>alert('操作失败，请重试！');window.history.go(-1);</script>";
			}
		}	
	}

 	public function workOn( $wid ) {
		$M = new Works();

		if( $M->updateWork($wid ,['works_status'=>1]) ) {
			echo "<script>alert('上架成功！');window.location.href='".url('home/workList')."'</script>";
		} else {
			echo "<script>alert('操作失败，请重试！');window.history.go(-1);</script>";
		}
	}
 	public function workOff( $wid ) {
		$M = new Works();

		if( $M->updateWork($wid ,['works_status'=>0]) ) {
			echo "<script>alert('下架成功！');window.location.href='".url('home/workList')."'</script>";
		} else {
			echo "<script>alert('操作失败，请重试！');window.history.go(-1);</script>";
		}
	}

	public function workDel( $wid ) {
		$M = new Works();

		if( $M->deleteWork($wid) ) {
			echo "<script>alert('删除成功！');window.location.href='".url('home/workList')."'</script>";
		} else {
			echo "<script>alert('操作失败，请重试！');window.history.go(-1);</script>";
		}
	}











}
