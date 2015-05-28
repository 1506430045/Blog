<?php
namespace Admin\Model;
use Think\Model;
class BlogModel extends Model {

	protected $db;
    protected $numPerPage;
	protected $errMsg;

	public function __construct() {
        $this->numPerPage = 10;
		$this->db = M('blog');
	}

    public function getBlogNum($cate, $recycle=0) {
        if(isset($cate) && !empty($cate)) {
            $sql = sprintf("select count(a.id) as num from b_blog a where a.recycle=%d and a.cateid=%d", $recycle, $cate);
        }else {
            $sql = sprintf("select count(a.id) as num from b_blog a where a.recycle=%d", $recycle);
        }
        $count = M()->query($sql);
        return $count[0]['num'];
    }

	public function listBlog($cate, $page, $recycle=0) {
        $first = ($page - 1) * $this->numPerPage;
        if(isset($cate) && !empty($cate)) {
            $sql = "select a.id,a.title,a.click,a.time,b.cname from b_blog a inner join b_cate b on a.cateid = b.id and b.id=%d and a.recycle=%d order by time desc limit %d,%d";
            $sql = sprintf($sql, $cate, $recycle,  $first, $this->numPerPage);
        } else {
            $sql = "select a.id,a.title,a.click,a.time,b.cname from b_blog a inner join b_cate b on a.cateid = b.id and a.recycle=%d order by time desc limit %d,%d";
            $sql = sprintf($sql, $recycle,  $first, $this->numPerPage);
        }
		$blogCate = M()->query($sql);
		foreach($blogCate as &$v) {
			$sql = 'select b.name,b.color from b_blog_tag a,b_tag b where b.id=a.tagid and a.blogid='.$v['id'];
			$blogTag = M()->query($sql);
			if($blogTag) {
				$v['tags'] = $blogTag;
			}
		}
		return $blogCate;
	}

	public function addBlogModel($arr) {
		$result = $this->db->add($arr);
		if ($result) {
			return $result;
		} else {
			$this->errMsg = '博文添加失败！';
			return false;
		}
	}

	public function addTagToBlog($bid, $tagArr) {
		$sql = 'INSERT INTO `b_blog_tag` (blogid, tagid) VALUES ';
		foreach($tagArr as $v) {
			$sql .= '('.$bid.','.$v.'),';
		}
		$sql = rtrim($sql, ',');
		$result = M()->execute($sql);
		if ($result) {
			return true;
		} else {
			$this->errMsg = '博文标签添加失败！';
			return false;
		}
	}

	public function getErrMsg() {
		return $this->errMsg;
	}
}
