<?php
//BlogModel.class.php
namespace Home\Model;
use Think\Model;
class BlogModel extends Model {

    protected $db;
    private $errMsg;

    public function __construct() {
        $this->db = M('blog');
    }

    public function getBlogByCateIdModel($cateId, $page, $limit, $showContent=false) {
        if($showContent) {
            $fields = "id,cateid,title,time,content";
        } else {
            $fields = "id,title,time";
        }
        $start = ($page-1)*$limit;
        $sql = sprintf("select {$fields} from b_blog where cateid=%d order by id desc limit %d,%d", $cateId, $start, $limit);
        $result = $this->db->query($sql);
        if(!$result) {
            $this->errMsg = "博文查询失败！";
        }
        return $result;
    }

    public function getBlogByIdModel($id) {
        $sql = sprintf("select a.id,a.title,a.click,a.time,a.content,b.cname from b_blog a inner join b_cate b on a.cateid=b.id and a.id=%d limit 1", $id);
        $result = $this->db->query($sql);
        if(!$result) {
            $this->errMsg = "博文查询失败！";
        }
        return $result;
    }

    public function getBlogIdsByTagIdModel($tagid) {
        $sql = "select blogid from b_blog_tag where tagid = %d";
        $sql = sprintf($sql, $tagid);
        $result = $this->db->query($sql);
        if(!$result) {
            $this->errMsg = '没有找到该tag对应的博文';
            return null;
        }
        return $result;
    }

    public function getBlogByIdsModel($ids, $showContent=false) {
        if(empty($ids)) {
            return null;
        }
        if($showContent) {
            $fields = "id,title,time,content";
        } else {
            $fields = "id,title,time";
        }
        $sql = sprintf("select {$fields} from b_blog where id in %s order by id desc", $ids);
        $result = $this->db->query($sql);
        return $result;
    }

    public function getBlogNum() {
        $maxid = $this->db->query("select max(id) as count from b_blog");
        $count = $maxid[0]['count'];
        return $count;
    }

    public function getBlogNumByCate($cate=0) {
        $sql = sprintf("select count('id') count from b_blog where cateid = %d", $cate);
        $result = $this->db->query($sql);
        return $result[0]['count'];
    }

    public function judgeIdExist($id) {
        $sql = sprintf("select id from b_blog where id = %d", $id);
        $result = $this->db->query($sql);
        return $result ? true : false;
    }

    public function searchBlog($keyword) {
        $sql = "select `id`,`title`,`time`,`content` from `b_blog` where `title` like '%{$keyword}%'";
        $result = $this->db->query($sql);
        return $result;
    }

    public function getBlogNumByMonth($year, $month) { 
        $sql = sprintf("select count(id) count from b_blog where year(from_unixtime(time))=%d and month(from_unixtime(time))=%d", $year, $month);
        $result = $this->db->query($sql);
        return $result[0]['count'];
    }

    public function getBlogByYearAndMonth($year, $month) {
        $sql = sprintf("select id,title,time,content from b_blog where year(from_unixtime(time))=%d and month(from_unixtime(time))=%d order by id desc", $year, $month);
        $result = $this->db->query($sql);
        return $result;
    }
	
	public function getTagNameById($id) {
		$sql = sprintf("select name from b_tag where id = %d", $id);
		$result = $this->db->query($sql);
		return $result[0]['name'];
	}

    public function getErrMsg() {
        return $this->errMsg;
    }
}
