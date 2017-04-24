<?php
namespace app\index\controller;
use app\index\model\User;

class Base extends \think\Controller {

	public $appid = "wxffa847bbc59cffad";
	public $appsecret = "d4624c36b6795d1d99dcf0547af5443d";

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



	// 获取微信用户基本信息
	public function getUserBase() {

		if( !isset($_GET['code']) ) {
			
			$redirect_uri = urlencode("http://www.iweibin.com/wchatShop/public/index/base/getUserBase");
			$scope = "snsapi_base";
			$url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=".$this->appid."&redirect_uri=".$redirect_uri."&response_type=code&scope=".$scope."&state=1525#wechat_redirect";

			header('location:'.$url);
			exit;

		} else {

			$code = $_GET['code'];

			$url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=".$this->appid."&secret=".$this->appsecret."&code=".$code."&grant_type=authorization_code";

			$res = $this->http_curl( $url ,"get" );

			return $res;
		}

	}

	// 获取微信用户详细信息
	public function getUserInfo() {

		if( !isset($_GET['code']) ) {

			$redirect_uri = urlencode("http://www.iweibin.com/wchatShop/public/index/base/getUserInfo");
			$scope = "snsapi_userinfo";

			$url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=".$this->appid."&redirect_uri=".$redirect_uri."&response_type=code&scope=".$scope."&state=1525#wechat_redirect";

			header('location:'.$url);
			exit;

		} else {

			$code = $_GET['code'];

			$url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=".$this->appid."&secret=".$this->appsecret."&code=".$code."&grant_type=authorization_code";

			$res = $this->http_curl( $url ,"get" );

			$openid = $res['openid'];
			$access_token = $res['access_token'];

			$url = "https://api.weixin.qq.com/sns/userinfo?access_token=".$access_token."&openid=".$openid."&lang=zh_CN";
			$res = $this->http_curl($url ,"get" );

			var_dump($res);

		}


	}

	public function auto_login() {

		if( !isset($_GET['code']) ) {

			$redirect_uri = urlencode("http://www.iweibin.com/wchatShop/public/index/base/auto_login");
			$scope = "snsapi_userinfo";

			$url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=".$this->appid."&redirect_uri=".$redirect_uri."&response_type=code&scope=".$scope."&state=1525#wechat_redirect";

			header('location:'.$url);
			exit;

		} else {

			$code = $_GET['code'];

			$url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=".$this->appid."&secret=".$this->appsecret."&code=".$code."&grant_type=authorization_code";

			$res = $this->http_curl( $url ,"get" );

			$openid = $res['openid'];

			$user = new User;
			$info = $user->getUserInfo($openid);

			if( $info ) {

				$user->update_info($info['user_id'] ,['last_login'=>time()]);

				cookie('signed_user',['userid'=>$info['user_id'],'nickname'=>$info['nickname']]);
				session('signed_user',['userid'=>$info['user_id'],'nickname'=>$info['nickname']]);
				$this->redirect('Index/test');

			} else {

				$access_token = $res['access_token'];

				$url = "https://api.weixin.qq.com/sns/userinfo?access_token=".$access_token."&openid=".$openid."&lang=zh_CN";
				$res = $this->http_curl($url ,"get" );

				$data = array(
					'openid'	=> $openid,
					'nickname'	=> $res['nickname'],
					'sex'	=> $res['sex'],
					'province'	=> $res['province'],
					'city'	=> $res['city'],
					'country'	=> $res['country'],
					'avatar'	=> $res['headimgurl'],
					'last_login'	=> time()
					);

				 if( $user->signup($data) ) {

					cookie('signed_user',['userid'=>$info['user_id'],'nickname'=>$info['nickname']]);
					session('signed_user',['userid'=>$info['user_id'],'nickname'=>$info['nickname']]);
					$this->redirect('Index/test');

				 } else {
				 	echo "add error";
				 }

				
			}


		}


	}

}


