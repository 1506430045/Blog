<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {

    protected $limit;
    protected $c_page;

    public function __construct() {
        parent::__construct();
		require_once APP_PATH . 'Common/MemcachedTool.class.php';
		$this->mem = \MemcachedTool::getInstance('127.0.0.1', 11211, 100);
        $this->limit = 5;
        $this->c_page = isset($_GET['page']) ? $_GET['page'] : 1;
    }

    public function index() {
		$key = md5(__METHOD__);
		if($list = $this->mem->get($key)){
			$this->assign('blog', $list);
		}else {
			$cate = D('cate')->getCatesModel();
	        $blog = array();
		    foreach($cate as $k => $v) {
			    $result = D('blog')->getBlogByCateIdModel($v['id'], 1, 10);
				$blog[$k]['blog'] = $result;
	            $blog[$k]['cname'] = $v['cname'];
		        $blog[$k]['cateid'] = $v['id'];
			}
			$this->mem->add($key, $blog, 60*60*24);
			$this->assign('blog', $blog);
		}
        $this->display();
    }

    public function cate() {
        $id = intval($_GET['id']);
		$key = md5(__METHOD__.$id.$this->c_page);
		if($list = $this->mem->get($key)){
			$this->content = $list;
		}else {
			$cname = D('cate')->getCateNameById($id);
			$count = D('blog')->getBlogNumByCate($id);
			if($count == 0) {
				$content = array(
						'cname'	=> $cname,
						'blog'	=> array(),
						'page'	=> ''
						);
				$this->assign('content', $content);
			}else {
				require_once APP_PATH . 'Common/Page.class.php';
				$page = \Page::getInstance($count, $this->c_page, 5);
				$pageStr = $page->getPageContent();

				$blog = D('blog')->getBlogByCateIdModel($id, $page->getPageIndex(), $this->limit, true);
				$content = array(
						'cname'	=>	$cname,
						'blog'	=>	$blog,
						'page'	=>	$pageStr
						);
				$this->assign('content', $content);
			}
			$this->mem->add($key, $content, 60*60*24);
		}
        $this->display();
    }

    public function blog() {
        $id = $_GET['id'];
		$key = md5(__METHOD__.$id);
		if($list = $this->mem->get($key)) {
			$this->assign('blog', $list);
		}else {
			$blog = D('blog')->getBlogByIdModel($id);
			$this->mem->add($key, $blog, 60*60*24);
	        $this->assign('blog', $blog);
		}
    	$this->display();
    }

    public function getBlogByTag() {
        $tagId = $_GET['id'];
		$key = md5(__METHOD__.$tagId.$this->c_page);
		if($list = $this->mem->get($key)){
			$this->assign('content', $list);
		}else {
			$tagName = D('blog')->getTagNameById($tagId);
			$blogIds = D('blog')->getBlogIdsByTagIdModel($tagId);
			$idsStr = '(';
			if(!empty($blogIds)) {
				foreach ($blogIds as $v) {
					$idsStr .= $v['blogid'].',';
				}
				$idsStr = rtrim($idsStr, ',');
				$idsStr = $idsStr.')';
				$blog = D('blog')->getBlogByIdsModel($idsStr, true);
				$content = array(
						'cname'	=>	$tagName,
						'blog'	=>	$blog,
						'page'	=>	''
						);
			}else{
				$content = array(
						'cname'	=>	$tagName,
						'blog'	=>	array(),
						'page'	=>	''
						);
			}
			$this->mem->add($key, $content, 60*60*24);
			$this->assign('content', $content);
		}
		$this->display('Index/cate');
    }
}
