<?php
namespace Admin\Controller;
use Think\Controller;
class BlogController extends Controller {

    protected $c_page;
    protected $c_cate;
    protected  $c_recycle;

    public function __construct() {
        parent::__construct();
        $this->c_page = isset($_GET['page']) ? $_GET['page'] : 1;
        $this->c_cate = intval($_GET['cate']);
        $this->c_recycle = isset($_GET['recycle']) ? $_GET['recycle'] : 0;
    }

	public function index() {
        $count = D('blog')->getBlogNum($this->c_cate, $this->c_recycle);
		if($count == 0){
			$this->blogs = array();
			$this->display();
		}else {
			require_once APP_PATH . 'Common/Page.class.php';
	        $page = \Page::getInstance($count, $this->c_page, 10);
		    $this->page = $page->getPageContent();

			$this->blogs = D('blog')->listBlog($this->c_cate, $page->getPageIndex(), $this->c_recycle);
			$this->cates = D('cate')->cateList();
			$this->tags = D('tag')->tagList();
			$this->assign('recycle', $this->c_recycle);
			$this->display();
		}
	}

	public function addBlog() {
		$blog = D('blog');
		$data = array(
			'title'		=>	I('post.title'),
			'cateid'	=>	I('post.cate'),
			'click'		=>	I('post.click'),
			'time'		=>	time(),
			'content'	=>	$_POST['content']
		);
		if ($bid = $blog->addBlogModel($data)) {
			if(!empty($_POST['tags'])) {
                if (!$blog->addTagToBlog(intval($bid), $_POST['tags'])) {
                    $this->error($blog->getErrMsg());
                } else {
                    $this->success('博文添加成功！');
                }
            } else {
                $this->success('博文添加成功！');
            }
		} else {
			$this->error($blog->getErrMsg());
		}
	}

    public function delBlog() {
        $id = $_GET['id'];
        $result = M('blog')->where(array('id'=>$id))->setField('recycle', 1);
        if($result) {
            $this->success('删除成功！');
        } else {
            $this->error('删除失败！');
        }
    }
}
