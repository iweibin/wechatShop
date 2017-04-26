<?php
namespace app\admin\model;
use think\Db;

class Gimg extends \think\Model {
	
	protected $table = "gimg";

	protected $M;

    public function __construct($table = '') {
    	parent::__construct();
    	
    	$this->M = Db::name($table ? $table : $this->table); 
    }



}