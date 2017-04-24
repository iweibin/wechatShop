<?php
namespace app\admin\controller;
use app\admin\model\User;
use think\Url;

class Base extends \think\Controller {

	public function __construct() {
		parent::__construct();


	}
	/**
	 *  http 请求
	 * @param [string] $url 请求地址
	 * @param [string] $request_type 请求方式
	 * @return json 
	 */
	public function http_curl( $url ,$request_type = "get" ) {

		$ch = curl_init();


		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);//如果成功只将结果返回，不自动输出任何内容。  
		curl_setopt($ch, CURLOPT_TIMEOUT, 500); //作为最大延续500毫秒，超过这个时间将不去读取页面
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);//不检测服务器的证书是否由正规浏览器认证过的授权CA颁发

		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);//不检测服务器的域名与证书上的是否一致

		curl_setopt($ch, CURLOPT_URL, $url);//设置提交地址路径

		$res = curl_exec($ch);//执行，并接收返回结果


		curl_close($ch);

		return json_decode($res ,true);
	}

	public function getUserKey() {

	}


	public function getRandStr() {

		$str = 'zxcvbnmasdfghjklqwertyuiop';
		$ret = '';
		for($i=0; $i<8; $i++) {
			$ret .= $str[rand(0,strlen($str)-1)];
		}
		return $ret;
	}

	public function checkLogin() {
		if( !session('user_admin') ) {
			echo "<script>alert('用户未登录，请先登录！');window.location.href='".url('index/index')."'</script>";
		}
	}

	public function upload(){
	    // 获取表单上传文件 例如上传了001.jpg
	    $file = request()->file('image');
	    // 移动到框架应用根目录/public/uploads/ 目录下
	    $info = $file->validate(['size'=>1024*1024*10,'ext'=>'jpg,png,gif,bmp,jpeg'])->move(ROOT_PATH . 'public' . DS . 'uploads');
	    if($info){
	        return ['savename' => $info->getSaveName()];
	    }else{
	        // 上传失败获取错误信息
	        return ['msg' => '上传失败,请重试！！！'];
	    }
	}


}


