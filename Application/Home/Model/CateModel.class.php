<?php
namespace Home\Model;
use Think\Model;
class CateModel extends Model {

    protected $db;
    private $errMsg;

    public function __construct() {
        $this->db = M('cate');
    }

    public function getCatesModel() {
        $cate = $this->db->field(array('id','cname'))->order('sort')->select();
        return $cate;
    }

    public function getCateNameById($id) {
        $name = $this->db->field('cname')->find($id);
        return $name['cname'];
    }
}