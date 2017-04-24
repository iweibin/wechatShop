<?php
namespace app\index\model;
use think\Db;

class Gimg extends \think\Model {



	public function goods() {
		return $this->hasOne('Goods','gimg_id');
	}

}