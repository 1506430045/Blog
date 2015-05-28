<?php
/**
 * Created by PhpStorm.
 * User: xiangqian
 * Date: 2015/4/26
 * Time: 23:30
 */
namespace Home\Widget;
use Think\Controller;
class NavWidget extends Controller {

	protected $mem;

	public function __construct() {
		parent::__construct();
		require_once APP_PATH . 'Common/MemcachedTool.class.php';
		$this->mem = \MemcachedTool::getInstance('127.0.0.1', 11211, 100);
	}

    public function nav() {
		$key = md5(__METHOD__);
		if($list = $this->mem->get($key)) {
			$this->cate = $list;
		}else {
			$this->cate = M('cate')->field(array('id','cname'))->select();
			$this->mem->add($key, $this->cate, 60*60*24);
		}
        $this->display('Nav:nav');
    }
}
