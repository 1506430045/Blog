<?php
namespace Admin\Model;
use Think\Model;
class TagModel extends Model {

	protected $db;

	public function __construct() {
		$this->db = M('tag');
	}

	public function tagList() {
		return $this->db->select();
	}

	public function addTagModel($tagName, $tagColor) {
		$result = $this->db->add(array('name'=>$tagName, 'color'=>'#'.$tagColor));
		if($result) {
			return true;
		} else {
			return false;
		}
	}

	public function delTagModel($id) {
		$result = $this->db->delete($id);
		return $result;
	}
}