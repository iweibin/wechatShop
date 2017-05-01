<?php
namespace app\admin\model;
use think\Db;

class Master extends \think\Model {
	
	protected $table = "master";

	protected $M;

    public function __construct($table = '') {
    	parent::__construct();
    	
    	$this->M = Db::name($table ? $table : $this->table); 
    }

    public function insertMaster( $data ) {
    	return $this->M->insert($data);
    }
    public function updateMaster( $mid ,$data) {
    	return $this->M->where(['master_id'=>$mid])->update($data);
    }
    public function deleteMaster( $mid ) {
    	return $this->M->where(['master_id'=>$mid])->delete();
    }

    public function getMasterList() {
    	return $this->M->select();
    }
    public function getNameList() {
    	return $this->M->field('master_id,master_name')->select();
    }

    public function getMasterInfo( $mid ) {
    	return $this->M->where(['master_id'=>$mid])->find();
    }

    public function getWorksById( $master_id ) {
    	return Db::name('works')->where(['master_id'=>$master_id])->select();
    }

}