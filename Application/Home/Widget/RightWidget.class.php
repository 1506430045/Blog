<?php
namespace Home\Widget;
use Think\Controller;
class RightWidget extends Controller {

	protected $mem;

	public function __construct() {
		parent::__construct();
		require_once APP_PATH . 'Common/MemcachedTool.class.php';
		$this->mem = \MemcachedTool::getInstance('127.0.0.1', 11211, 100);
	}

    public function cale() {
        // 显示日历
        require APP_PATH . 'Common/Cale.class.php';
        $cale = new Cale;
        $this->assign('cale', $cale->show());
        $this->display('Right:cale');
    }

    public function tag() {
		$key = md5(__METHOD__);
		if($list = $this->mem->get($key)){
			$this->tag = $list;
		}else {
			$this->tag = M('tag')->order('id desc')->select();
			$this->mem->add($key, $this->tag, 60*60*24);
		}
		$this->display('Right:tag');
    }

    public function newBlog() {
		$key = md5(__METHOD__);
		if($list = $this->mem->get($key)){
			$this->newBlog = $list;
		}else {
			$this->newBlog = M('blog')->order('click desc')->limit(5)->select();
			$this->mem->add($key, $this->newBlog, 60*60*24);
		}
		$this->display('Right:new');
    }

    public function hotBlog() {
		$key = md5(__METHOD__);
		if($list = $this->mem->get($key)){
			$this->hotBlog = $list;
		}else {
			$this->hotBlog = M('blog')->order('click desc')->limit(5)->select();
			$this->mem->add($key, $this->hotBlog, 60*60*24);
		}
		$this->display('Right:hot');
    }

    public function randomBlog() {
		$key = md5(__METHOD__);
		if($list = $this->mem->get($key)) {
			$this->assign('blog', $list);
		}else {
			$count = D('blog')->getBlogNum();
			$ids = array();
			while (count($ids) < 5) {
				$randId = rand(1, $count);
				if(!in_array($randId, $ids)){
					$ids[] = $randId;
				}
			}
			$idsStr = '('.implode(',', $ids).')';
			$blog = D('blog')->getBlogByIdsModel($idsStr, false);
			$this->mem->add($key, $blog, 60*60*24);
			$this->assign('blog', $blog);
		}
        $this->display('Right:random');
    }

    public function suibi() {
        $time = time();
        $year = intval(date('Y', $time));
        $month = intval(date('n', $time));
		$key = md5(__METHOD__.$year.$month);
		if($list = $this->mem->get($key)) {
			$this->yearAndMonth = $list;
			$this->display('Right:suibi');
		}else {
			$yearAndMonth = array();
	        for ($i=0; $i < 5; $i++) { 
		        $yearAndMonth[$i]['year'] = ($month-$i)>0 ? $year : $year-1;
			    $yearAndMonth[$i]['month'] = ($month-$i)>=1 ? $month-$i : $month-$i+12;
				$yearAndMonth[$i]['num'] = D('blog')->getBlogNumByMonth($yearAndMonth[$i]['year'], $yearAndMonth[$i]['month']);
			}
			$this->mem->add($key, $yearAndMonth, 60*60*24);
			$this->yearAndMonth = $yearAndMonth;
			$this->display('Right:suibi');
		}
    }
}
