<?php
namespace Admin\Controller;
use Think\Controller;
class IndexController extends CommonController {

	public function flush() {
		require_once APP_PATH . 'Common/MemcachedTool.class.php';
		$mem = \MemcachedTool::getInstance('127.0.0.1', 11211, 100);
		$mem->flush();
		$this->redirect('Index/index');
	}

	public function index() {
		$manager = D('manager');
		$result = $manager->getManager();
		$this->assign('list', $result);
		$this->display();
	}

	public function addManager() {
		$username = I('post.username');
		$password = I('post.password');
		$repass = I('post.repass');
		$role = I('post.role','','intval');
		if ($password !== $repass) {
			$this->error('两次密码输入不一致！');
		}
		$manager = D('manager');
		$result = $manager->addManagerModel($username, md5($password), $role);
		if($result) {
			$this->success('添加成功','index');
		} else {
			$this->error($manager->getErrMsg());
		}
	}	


}
