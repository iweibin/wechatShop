<?php
namespace app\admin\model;
use think\Db;

class Goods extends \think\Model {
	
	protected $table = "goods";

	protected $M;

    public function __construct($table = '') {
    	parent::__construct();
    	
    	$this->M = Db::name($this->table ? $this->table : $table); 
    }



}