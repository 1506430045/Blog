<?php
namespace Admin\Controller;
use Think\Controller;
class CommonController extends Controller {
	public function _initialize() { 
		if (!isset($_SESSION['username']) || empty($_SESSION['username'])) {
			$this->redirect('Login/logout');
		}
	}
}