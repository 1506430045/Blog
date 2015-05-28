<?php
namespace Home\Controller;
use Think\Controller;

class SearchController extends Controller {

	protected $mem;

	public function __construct() {
		parent::__construct();
		require_once APP_PATH . 'Common/MemcachedTool.class.php';
		$this->mem = \MemcachedTool::getInstance('127.0.0.1', 11211, 100);
	}

	public function search() {
		$keyword = $_POST['keyword'];
		if(get_magic_quotes_gpc()) {
			stripslashes($keyword);
		}
		$keyword = mysql_escape_string($keyword);
		if(empty($keyword)) {
			$keyword = 'php';
		}
		$key = md5(__METHOD__.$keyword);
		if($list = $this->mem->get($key)) {
			$this->content = $list;
		}else {
			$blog = D('blog')->searchBlog($keyword);	
			$content = array(
					'cname'	=>	$keyword,
					'blog'	=>	$blog,
					'page'	=>	''
					);
			$this->mem->add($key, $content, 60*60*24);
			$this->assign('content', $content);
		}
		$this->display('Index/cate');
	}

	public function suibi() {
		$year = $_GET['y'];
		$month = $_GET['m'];
		$key = md5(__METHOD__.$year.$month);
		if($list = $this->mem->get($key)) {
			$this->assign('content', $list);
			$this->display('Index/cate');
		}else {
			$list = D('blog')->getBlogByYearAndMonth($year, $month);
			$content = array(
					'cname'	=>  $year.'年'.$month.'月',	
					'blog'	=>	$list,
					'page'	=>	''
					);
			$this->mem->add($key, $content, 60*60*24);
			$this->assign('content', $content);
			$this->display('Index/cate');
		}
	}
}
?>
