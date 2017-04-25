<?php
namespace app\admin\model;
use think\Db;

class Goods extends \think\Model {
	
	protected $table = "goods";

	protected $M;

    public function __construct($table = '') {
    	parent::__construct();
    	
    	$this->M = Db::name($table ? $table : $this->table); 
    }

    public function insertGoods($data) {
    	return $this->M->insert($data);
    }
    public function updateGoods($gid ,$data) {
        return $this->M->where(['gid'=>$gid])->update($data);
    }
    public function deleteGoods($gid) {
        return $this->M->where(['gid'=>$gid])->delete();
    }

    public function getGoodsList() {
    	return $this->M->order('gtime desc')->select();
    }

    public function getGoodsType() {
    	return Db::name('goods_class')->select();
    }

    public function getGoodByGid( $gid = '' ) {
        return $this->M->where(['gid'=>$gid])->find();
    }


}