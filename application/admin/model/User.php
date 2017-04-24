<?php
namespace app\admin\model;
use think\Db;

class User extends \think\Model {
	
	protected $table = "admin";

	protected $M;

    public function __construct() {
    	parent::__construct();
    	
    	$this->M = Db::name($this->table); 
    }


	public function getUserInfo( $username ) {
		return $this->M->where('username' ,$username)->find();
	}

	public function signup( $data ) {
		return $this->M->insert($data);
	}

	public function update_info( $username ,$data ) {
		return $this->M->where('username', $username)->update($data);
	}
}