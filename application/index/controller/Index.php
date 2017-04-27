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
		$carousel = Db::view('gimg','gimg_url')
    	->where('gimg_choice','=',1)
    	->select();
		$this->assign('carousel', $carousel);
        $this->assign('count', count($carousel)>6?6:count($carousel));
        $this->assign('flag', 1);
	}

	public function getRecommend(){
		$recommend = Db::view('gimg','gimg_url')
		->view('goods', 'gname, gpri', 'gimg.gimg_id = goods.gimg_id')
    	->where('gchoice','=',2)
    	->select();
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
				$list = Db::view('gimg','gimg_url')
	    		->view('goods','gname, gpri','goods.gimg_id=gimg.gimg_id')
	    		->where('gchoice','>',1)
	    		->order('gimg.gid','desc')
	    		->select();
				break;

			case 'tehui':
				$list = Db::view('gimg','gimg_url')
	    		->view('goods','gname, gpri','goods.gimg_id=gimg.gimg_id')
	    		->where('gpreferential','=',1)
	    		->order('gimg.gid','desc')
	    		->select();
				break;

			case 'rexiao':
				$list = Db::view('gimg','gimg_url')
	    		->view('goods','gname, gpri','goods.gimg_id=gimg.gimg_id')
	    		->order('gsales','desc')
	    		->select();
				break;

			default:
				$list = Db::view('gimg','gimg_url')
	    		->view('goods','gname, gpri','goods.gimg_id=gimg.gimg_id')
	    		->view('goods_class','gtype_id','goods_class.gtype_id=goods.gtype_id')
	    		->where('gchoice','>',1)
	    		->where('gtype_name',$module)
	    		->select();
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
