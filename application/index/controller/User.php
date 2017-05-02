<?php
namespace app\index\controller;
use think\Config;
use think\Db;
use think\Request;
use think\Cache;

class User extends Base {

	public function __construct() {
		parent::__construct();
	}

    public function get_user() {
        /*
        $user = Session::get('signed_user');
        $openid = $user['userid'];
        */
        $openid = '1111111111';
        return $user = Db::table('user')->where('openid', $openid)->find(); 
    }


    //个人信息 主页面 center.html
	public function center() {

        $user = $this->get_user();
        $this->assign('user',$user);
        return $this->fetch('index/center');
	}

    //查看某一产品新息
    public function product($gid = null) {
        $user = $this->get_user();
        $this->assign('user',$user);
        $product = Db::table('goods')->where('gid', $gid)->find();
        $this->assign('product',$product);
        return $this->fetch('index/product');
    }


    //全部订单
	public function shopping_all() {
		
        $user = $this->get_user();
        $join = [
            ['address a','o.add_id = a.add_id'],
            ['shopping_cart s','o.shopping_order_id = s.shopping_order_id'],
        ];

        $order = Db::table('order')->alias('o')
                                   ->join('address a','o.add_id = a.add_id')
                                   ->join('shopping_cart s','o.shopping_order_id = s.shopping_order_id')
                                   ->join('goods g', 'g.gid = s.gid')
                                  // ->join('gimg m', 'm.gid = g.gid')
                                   ->where('o.user_id',$user['user_id'])
                                   //->where('order_status', '0')
                                   ->order('order_time desc')
                                   ->select();

        foreach ($order as $key => $value) {
           
        	$order[$key]['gimg'] = Db::table('gimg')->where('gid', $value['gid'])->find();
         
        }


        $this->assign('order',$order);
        $this->assign('user',$user);
        return $this->fetch('index/shoppingAll');
	}

    //等待付款页面
	public function wait_pay() {

	    $user = $this->get_user();
        $join = [
            ['address a','o.add_id = a.add_id'],
            ['shopping_cart s','o.shopping_order_id = s.shopping_order_id'],
        ];

        $order = Db::table('order')->alias('o')
                                   ->join('address a','o.add_id = a.add_id')
                                   ->join('shopping_cart s','o.shopping_order_id = s.shopping_order_id')
                                   ->join('goods g', 'g.gid = s.gid')
                                  // ->join('gimg m', 'm.gid = g.gid')
                                   ->where('o.user_id',$user['user_id'])
                                   ->where('order_status', '0')
                                   ->order('order_time desc')
                                   ->select();

        foreach ($order as $key => $value) {
           
            $order[$key]['gimg'] = Db::table('gimg')->where('gid', $value['gid'])->find();
         
        }


        $this->assign('order',$order);
        $this->assign('user',$user);
        return $this->fetch('index/waitPay');
	}

	public function wait_send() {
		$user = $this->get_user();
        $join = [
            ['address a','o.add_id = a.add_id'],
            ['shopping_cart s','o.shopping_order_id = s.shopping_order_id'],
        ];

        $order = Db::table('order')->alias('o')
                                   ->join('address a','o.add_id = a.add_id')
                                   ->join('shopping_cart s','o.shopping_order_id = s.shopping_order_id')
                                   ->join('goods g', 'g.gid = s.gid')
                                  // ->join('gimg m', 'm.gid = g.gid')
                                   ->where('o.user_id',$user['user_id'])
                                   ->where('order_status', '1')
                                   ->order('order_time desc')
                                   ->select();

        foreach ($order as $key => $value) {
           
            $order[$key]['gimg'] = Db::table('gimg')->where('gid', $value['gid'])->find();
         
        }


        $this->assign('order',$order);
        $this->assign('user',$user);
        return $this->fetch('index/waitSend');

	}

	public function wait_comfirm() {
		
        $user = $this->get_user();
        $join = [
            ['address a','o.add_id = a.add_id'],
            ['shopping_cart s','o.shopping_order_id = s.shopping_order_id'],
        ];

        $order = Db::table('order')->alias('o')
                                   ->join('address a','o.add_id = a.add_id')
                                   ->join('shopping_cart s','o.shopping_order_id = s.shopping_order_id')
                                   ->join('goods g', 'g.gid = s.gid')
                                  // ->join('gimg m', 'm.gid = g.gid')
                                   ->where('o.user_id',$user['user_id'])
                                   ->where('order_status', '2')
                                   ->order('order_time desc')
                                   ->select();

        foreach ($order as $key => $value) {
           
            $order[$key]['gimg'] = Db::table('gimg')->where('gid', $value['gid'])->find();
         
        }


        $this->assign('order',$order);
        $this->assign('user',$user);
        return $this->fetch('index/waitComfirm');

	}

	public function address() {
	    $user = $this->get_user();

        $address = Db::table('address')->where('user_id', $user['user_id'])->select();
        //$default = Db::table('address')->where('user_id', $user['user_id'])->where('add_default = 1')->find();
        $this->assign('user',$user);
        $this->assign('address',$address);
        return $this->fetch('index/address');

	}

    //增加地址信息
    public function add_address() {
        $user = $this->get_user();
        $address = array();

        $request = Request::instance();
        if($request->isPost()) {

            $data['add_detail'] = $request->post('detail','');
            $data['add_name'] = $request->post('name','');
            $data['add_telephone'] = $request->post('tel','');
            $data['user_id'] = $user['user_id'];
            $data['add_default'] = '0';
        
            Db::table('address')->insert($data);
            //添加成功 跳转页面
            $this->redirect('User/address');
        }

        return $this->fetch('index/addAddress');
    }
    

    //修改地址信息
	public function edit_address($add_id = null) {

        $user = $this->get_user();
        $address = Db::table('address')->where('add_id',$add_id)->find();

        $request = Request::instance();
        if ($request->isPost()) { 
           
           $data['add_id'] = $request->post('add_id', '');
        
           $data['add_detail'] = $request->post('detail', '');
           $data['add_name'] = $request->post('name', '');
           $data['add_telephone'] =$request->post('tel', '');

           Db::table('address')->where('add_id',$data['add_id'])->update($data);
         //修改成功 跳回地址信息页面
		   $this->redirect('User/address');
           	
        }
        $this->assign('address',$address);
		return $this->fetch('index/editAddress');
	}

	//删除地址信息
	public function del_address($add_id = null) {
		$user = $this->get_user();
        $address = Db::table('address')->where('add_id',$add_id)->find();
        $this->assign('address',$address);
		if($add_id) {
			Db::table('address')->where('add_id',$add_id)->delete();
			//删除成功 跳回地址信息页面
			$this->redirect('User/address');
		}

	}

    //设置 默认收货地址
    public function def_add() {

    } 





	
}