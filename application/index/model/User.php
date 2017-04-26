<?php
namespace app\index\model;
use think\Db;

class User extends \think\Model {
	
	protected $table = "user";

	protected $M;

    public function __construct() {
    	parent::__construct();
    	$this->M = Db::name($this->table); 
    }


	public function getUserInfo( $openid ) {
		return $this->M->where('openid' ,$openid)->find();
	}

	public function signup( $data ) {
		return $this->M->insert($data);
	}

	public function update_info( $user_id ,$data ) {
		return $this->M->where('user_id', $user_id)->update($data);
	}
}