<?php
namespace app\admin\model;
use think\Db;

class HomeModel extends \think\Model {
	
	protected $table = "user";

	protected $M;

    public function __construct($table = '') {
    	parent::__construct();
    	
    	$this->M = Db::name($table ? $table : $this->table); 
    }


	public function getUserInfo( $username ) {
		return $this->M->where('username' ,$username)->find();
	}

	public function getUserList() {
		return $this->M->select();
	}

	public function userDel( $uid ) {
		return $this->M->where('user_id' ,$uid)->delete();
	}
}