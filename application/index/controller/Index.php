<?php
namespace app\index\controller;
use app\index\controller\Base;
use think\Db;

class Index extends Base {

	public function __construct() {
		parent::__construct();
	}


	public function index(){
		//$this->auto_login();// 调用微信自动登录
	}

	public function load($page){
		$this->getCarousel();	
		$this->getRecommend();
		$this->getPage($page);

        return $this->fetch('index');

	}

	public function getCarousel(){
		$carousel = Db::table('goods')
    	->where('gchoice','=',2)
    	->select();
        foreach ($carousel as $key => &$value) {
        	foreach ($value as $key1 => &$value1) {
        		if($key1 == 'gpic'){
        			        	$data = json_decode($value1);
        			        	$value1 = $data[0];
        		}
        	}
        }
        $this->assign('carousel', $carousel);
        $this->assign('count', count($carousel)>6?6:count($carousel));
        $this->assign('flag', 1);
	}

	public function getRecommend(){
		$recommend = Db::table('goods')
    	->where('gchoice','>',0)
    	->select();
        foreach ($recommend as $key => &$value) {
        	foreach ($value as $key1 => &$value1) {
        		if($key1 == 'gpic'){
        			        	$data = json_decode($value1);
        			        	$value1 = $data[0];
        		}
        	}
        }
		$this->assign('recommend', $recommend);
	}

	public function getPage($page){
		if ($page == 'index') {
			$this->getList('new');
			$this->getList('wenchuang');
			$this->getList('wenju');
			$this->getList('dszp');	
		}else{
			$this->getList($page);
			$this->getList('tehui');
			$this->getList('rexiao');	
		}

		$this->assign('name',$this->getName($page));
		$this->assign('page', $page);
	}

	public function getList($module = 'list')
	{
		switch ($module) {
			case 'new':
				$list = Db::table('goods')
	    		->where('gchoice','>',0)
	    		->order('gid','desc')
	    		->select();
		        foreach ($list as $key => &$value) {
		        	foreach ($value as $key1 => &$value1) {
		        		if($key1 == 'gpic'){
		        			        	$data = json_decode($value1);
		        			        	$value1 = $data[0];
		        		}
		        	}
	        	}
				break;

			case 'tehui':
				$list = Db::table('goods')
	    		->where('gpreferential','=',1)
	    		->order('gid','desc')
	    		->select();
		        foreach ($list as $key => &$value) {
		        	foreach ($value as $key1 => &$value1) {
		        		if($key1 == 'gpic'){
		        			        	$data = json_decode($value1);
		        			        	$value1 = $data[0];
		        		}
		        	}
	        	}
				break;

			case 'rexiao':
				$list = Db::table('goods')
	    		->order('gsales','desc')
	    		->select();
	    		foreach ($list as $key => &$value) {
		        	foreach ($value as $key1 => &$value1) {
		        		if($key1 == 'gpic'){
		        			        	$data = json_decode($value1);
		        			        	$value1 = $data[0];
		        		}
		        	}
	        	}
				break;

			default:
				$list = Db::table('goods')
				->view('goods','gname, gpri, gpic')
	    		->view('goods_class','gtype_id','goods_class.gtype_id=goods.gtype_id')
	    		->where('gchoice','>',0)
	    		->where('gtype_name',$module)
	    		->select();
	    		foreach ($list as $key => &$value) {
		        	foreach ($value as $key1 => &$value1) {
		        		if($key1 == 'gpic'){
		        			        	$data = json_decode($value1);
		        			        	$value1 = $data[0];
		        		}
		        	}
	        	}
				break;
		}
		$this->assign("$module", $list);
	}

	public function getName($page)
	{
		if ($page != 'index') {
			switch ($page) {
				case 'wenju':
					$name = "文具优品";
					break;
				case 'dalu':
					$name = "大陆优品";
					break;

				case 'riyongpin':
					$name = "日用优品";
					break;

				case 'taiwan':
					$name = "台湾优品";
					break;

				case 'wenchuang':
					$name = "文创优品";
					break;
				
				default:
					break;
			}

			return $name;
			}
		}

}
