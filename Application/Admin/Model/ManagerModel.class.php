<?php
namespace Admin\Model;
use Think\Model;
class ManagerModel extends Model {

	protected $dbObj;
	protected $errMsg = '';

	public function __construct() {
		$this->dbObj = M('manager');
	}

	public function login($username, $password, $verify) {
		$where = array(
			'username'	=>	$username,
			'password'	=>	$password
		);
		$sql = "select * from b_manager where username='%s' && password='%s' limit 1";
		$sql = sprintf($sql, $username, $password);
		$data = $this->dbObj->query($sql);
		if ($data) {
			if ($this->checkVerify($verify, $id='1')) {
				return $data;
			} else {
				$this->errMsg = '验证码错误，请重试。。。';
				return false;
			} 
		} else {
			$this->errMsg = '用户名或者密码输入有误，请重试。。。';
			return false;
		}
	}

	// manager登录成功更新登录状态
	public function updLoginStatus($id, $loginTime, $loginIp) {
		$data['logintime'] = $loginTime;
		$data['loginip'] = $loginIp;
		$this->dbObj->where(array('id'=>$id))->save($data);
	}

	// manager管理
	public function getManager($id='') {
		if (empty($id)) {
			$data = $this->dbObj->order('logintime')->limit(10)->select();
		} else {
			$data = $this->dbObj->where(array('id'=>$id))->find();
		}
		return $data;
	}

	// 添加manager
	public function addManagerModel($username, $password, $role) {
		$arr = array(
			'username'	=>	$username,
			'password'	=>	$password,
			'role'	=>	$role
		);
		if($this->dbObj->add($arr)) {
			return true;
		} else {
			$this->errMsg = '添加manager失败！';
			return false;	
		}
	}

	private function checkVerify($code, $id='') {
		$verify = new \Think\Verify();
		return $verify->check($code, $id);
	}

	public function getErrMsg() {
		return $this->errMsg;
	}
}
?>