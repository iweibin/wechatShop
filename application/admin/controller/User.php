<?php
namespace app\admin\controller;
use app\admin\controller\Base;
use think\Url;

class User extends Base {

	public function index() {
		return $this->fetch('/login');
	}

	public function login() {

		$username = input('post.username');
		$password = input('post.password');

		$M = new \app\admin\model\User();

		$userinfo = $M->getUserInfo($username);

		if( $userinfo ) {
			if($userinfo['password'] == md5(md5($password).$userinfo['user_key'])) {

				session('user_admin',['uid'=>$userinfo['uid'],'username'=>$userinfo['username'],'nickname'=>$userinfo['nickname']]);
				unset($userinfo);
				echo "<script>alert('登录成功！');window.location.href='".url('home/index')."'</script>";
			} else {
				echo "<script>alert('密码错误，请重新输入！');window.location.href='".url('index/index')."'</script>";
			}
		} else {
			echo "<script>alert('用户名错误，请重新输入！');window.location.href='".url('index/index')."'</script>";
		}

	}

	public function logout() {
		// Url::root('./index.php');
		session('user_admin',null);
		if( !session('user_admin') ) {
			echo "<script>alert('已退出登录！');window.location.href='".url('index/index')."'</script>";
		}
	}
}