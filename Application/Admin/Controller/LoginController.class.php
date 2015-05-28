<?php
namespace Admin\Controller;
use Think\Controller;
class LoginController extends Controller {
	public function login() {
		$this->display();
	}

	public function doLogin() {
		$username = I('post.username');
		$password = I('post.password', '', 'md5');
		$verify = I('post.verify');

		$manager = D('manager');
		$result = $manager->login($username, $password, $verify);
		if ($result) {
			$_SESSION['username'] = md5($username); 
			$manager->updLoginStatus($result['id'], time(), get_client_ip());
			$this->success('登录成功！', U('Index/index'));
		} else {
			$this->error($manager->getErrMsg());
		}
	}

	public function logout() {
		if (isset($_SESSION['username']) || !empty($_SESSION['username'])) {
			unset($_SESSION['username']);
		}
		$this->redirect('Login/login');
	}

	public function verify() {
		$config = array(
			'imageW' => 96,
			'imageH' => 26,
			'length' => 4,
			'fontSize' => 13
		);
		$verify = new \Think\Verify($config);
		$verify->entry('1');
	}
}