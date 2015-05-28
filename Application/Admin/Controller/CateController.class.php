<?php
namespace Admin\Controller;
use Think\Controller;
class CateController extends CommonController {

	public function index() {
		$this->cate = D('cate')->cateList();
		$this->display();
	}

    public function addCate() {
        if(checkEmptyArr($_POST)) {
            $this->error('请填写完整数据，感谢！');
        }
        $result = D('cate')->addCateModel($_POST['catename'],$_POST['sort'],$_POST['pid']);
        if($result) {
            $this->success('添加分类成功！');
        } else {
            $this->error(D('cate')->getErrMsg());
        }
    }

    public function delCate() {
        $id = $_GET['id'];
        $result = D('cate')->delCateModel($id);
        if($result) {
            $this->success('删除分类成功！');
        } else {
            $this->error('删除分类失败！');
        }
    }

    public function delAllCheckedCate() {
        if(checkEmptyArr($_POST)) {
            $re['msg'] = '你尚未选中任何选择框！';
            $re['status'] = 'failed';
        } else {
            $checkedStr = $_POST['checkedStr'];
            $checkedStr = rtrim($checkedStr, ',');
            $sql = "DELETE FROM b_cate WHERE `id` IN ({$checkedStr})";
            $result = M('cate')->execute($sql);
            if($result) {
                $re['status'] = 'success';
                $re['msg'] = '删除Cate成功！';
            } else {
                $re['status'] = 'failed';
                $re['msg'] = '删除Cate失败！';
            }
        }
        $re['sql'] = $sql;
        exit(json_encode($re));
    }

    public function  updSort() {
        $result = json_decode($_POST['result'],true);
        $ids = '';
        $sql = "UPDATE b_cate SET sort = CASE id ";
        foreach($result as $v) {
            $sql .= sprintf("WHEN %d THEN %d ", $v['id'], $v['sort']);
            $ids .= $v['id'].',';
        }
        $ids = rtrim($ids, ',');
        $sql .= "END WHERE id IN($ids)";
        if(M()->execute($sql)) {
            $re['status'] = 'success';
            $re['msg'] = 'Sort更新成功！';
        }else {
            $re['status'] = 'error';
            $re['msg'] = 'Sort更新失败！';
        }
        exit(json_encode($re));
    }
}