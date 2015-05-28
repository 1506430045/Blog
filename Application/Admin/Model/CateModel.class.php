<?php
namespace Admin\Model;
use Think\Model;
class CateModel extends Model {
	protected $dbObj;
	protected $errMsg = '';

	public function __construct() {
		$this->dbObj = M('cate');
	}

	public function cateList() {
		$result = $this->dbObj->order('id desc')->select();
		return $result;
	}

    public function addCateModel($name, $sort, $pid) {
        $data = array(
            'cname' =>  $name,
            'sort'  =>  $sort,
            'pid'   =>  $pid
        );
        $result = $this->dbObj->add($data);
        if(!$result)
            $this->errMsg = '添加分类失败！';
        return $result;
    }

    public function delCateModel($id) {
        $result = $this->dbObj->delete($id);
        return $result;
    }

    public function getErrMsg() {
        return $this->errMsg;
    }
}