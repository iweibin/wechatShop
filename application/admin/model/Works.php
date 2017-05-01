<?php
namespace app\admin\model;
use think\Db;

class Works extends \think\Model {
	
	protected $table = "works";

	protected $M;

    public function __construct($table = '') {
    	parent::__construct();
    	
    	$this->M = Db::name($table ? $table : $this->table); 
    }

    public function insertWorks( $data ) {
    	return $this->M->insert($data);
    }

    public function getWorkList() {
        return $this->M->alias('a')->join('master m','a.master_id = m.master_id','LEFT')->select();
    }

    public function updateWork( $wid ,$data ) {
        return $this->M->where(['works_id'=>$wid])->update($data);
    }
    public function deleteWork( $wid ) {
        return $this->M->where(['works_id'=>$wid])->delete();
    }

    public function getWorkByid($wid) {
        return $this->M->where(['works_id'=>$wid])->find();
    }
}