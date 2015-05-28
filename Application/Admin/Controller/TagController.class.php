<?php
namespace Admin\Controller;
use Think\Controller;
class TagController extends CommonController {
	public function index() {
		$tags = D('tag')->tagList();
		$this->assign('tags', $tags);
		$this->display();
	}

	public function addTag() {
        if(checkEmptyArr($_POST)) {
            $this->error('数据不能为空！');
        }
		$tags = D('tag');
		$result = $tags->addTagModel(I('post.tagname', '', 'addslashes'), I('post.color', '', 'addslashes'));
		if($result) {
			$this->success('添加标签成功！');
		} else {
			$this->error('添加标签失败！');
		}
	}

	public function delTag() {
		$id = I('get.id');
		$tags = D('tag');
		$result = $tags->delTagModel(intval($id));
		if($result) {
			$this->success('删除标签成功！');
		} else {
			$this->error('删除标签失败！');
		}
    }

    public function delAllCheckedTag() {
        if(checkEmptyArr($_POST)) {
            $re['msg'] = '你尚未选中任何选择框！';
            $re['status'] = 'failed';
        } else {
            $checkedStr = $_POST['checkedStr'];
            $checkedStr = rtrim($checkedStr, ',');
            $sql = "DELETE FROM b_tag WHERE `id` IN ({$checkedStr})";
            $result = M('tag')->execute($sql);
            if($result) {
                $re['status'] = 'success';
                $re['msg'] = '删除Tag成功！';
            } else {
                $re['status'] = 'failed';
                $re['msg'] = '删除Tag失败！';
            }
        }
        $re['sql'] = $sql;
        exit(json_encode($re));
    }

    public function selTag() {
        $id = $_POST['id'];
        $result = M('tag')->query("select * from b_tag where id={$id} limit 1");
        if($result) {
            $result['status'] = 'success';
            exit(json_encode($result));
        } else {
            $result['status'] = 'error';
        }
    }
}