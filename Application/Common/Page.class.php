<?php
class Page {

	private $totalNum;			//数据总条数
	private $pageIndex;			//当前页
	private $numPerPage;		//每页显示条数
	private $totalPage;			//总页数
	private $pageUrl;			//页面链接
	private static $_instance;	//实例

	public function __construct($totalNum, $pageIndex, $numPerPage=10) {
		if(!isset($totalNum) || !isset($pageIndex)) {
			die('请填写必要参数：数据总条数和当前页');
		}

		$this->totalNum = $totalNum;
		$this->pageIndex = $pageIndex;
		$this->numPerPage = $numPerPage;
		$this->totalPage = ceil($this->totalNum/$this->numPerPage);
		$this->pageUrl = $this->getPageUrl();
		//检测非法数据
		$this->initPageLegal();
	}

	public function getPageIndex() {
		return $this->pageIndex;
	}

	private function initPageLegal() {
		if(!is_numeric($this->pageIndex) || $this->pageIndex<1) {
			$this->pageIndex = 1;
		}
		if($this->pageIndex > $this->totalPage) {
			$this->pageIndex = $this->totalPage;
		}
	}

	private function getPageUrl() {
		$currentUrl = $_SERVER['REQUEST_URI'];	//url中出域名外的其他部分
		$arrUrl = parse_url($currentUrl);		//解析url
		$urlQuery = '';
		if(array_key_exists('query', $arrUrl)) {
			$urlQuery = $arrUrl["query"];			//查询字符串(?后面的那部分)
		}
		if($urlQuery) {
			//将$urlQuery中的类似page=1或者&page=1替换为空
			$urlQuery  = preg_replace("/(^|&)page=".$this->pageIndex."/", "", $urlQuery);
			$currentUrl = str_replace($arrUrl["query"], $urlQuery, $currentUrl);
			if($urlQuery) {
				$currentUrl .= '&page';
			}else {
				$currentUrl .= 'page';
			}
		}else {
			$currentUrl .= '?page';
		}
		return $currentUrl;
	}


	public function getPageContent() {
		$str = "<div class=\"Pagination\">";
		if($this->pageIndex == 1){
			$str .="<a href='javascript:void(0)' class='tips' title='首页'>首页</a> "."\n";
			$str .="<a href='javascript:void(0)' class='tips' title='上一页'>上一页</a> "."\n"."\n";
		}else{
			$str .="<a href='{$this->pageUrl}=1' class='tips' title='首页'>首页</a> "."\n";
			$str .="<a href='{$this->pageUrl}=".($this->pageIndex-1)."' class='tips' title='上一页'>上一页</a> "."\n"."\n";
		}

		if($this->totalPage <= 10) {
			for($i=1; $i<=$this->totalPage; $i++) {
				if($this->pageIndex == $i) {
					$str .="<a href='{$this->pageUrl}={$i} ' class='current'>$i</a>"."\n" ;
				}else {
					$str .="<a href='{$this->pageUrl}={$i} '>$i</a>"."\n" ;
				}
			}
		}else {
			if($this->pageIndex < 3) {
				for($i=1; $i<3; $i++) {
					if($this->pageIndex == $i) {
						$str .="<a href='{$this->pageUrl}={$i} ' class='current'>$i</a>"."\n" ;
					}else {
						$str .="<a href='{$this->pageUrl}={$i} '>$i</a>"."\n" ;
					}		
				}
				$str.="<span class=\"dot\">……</span>"."\n";
				for($i=$this->totalPage-3+1; $i<=$this->totalPage; $i++){//功能1
                	$str .="<a href='{$this->pageUrl}={$i}' >$i</a>"."\n" ; 
		    	}
			}elseif ($this->pageIndex <=5) {
				for($i=1; $i<=$this->pageIndex+1; $i++){
					if($this->pageIndex == $i) {
						$str .="<a href='{$this->pageUrl}={$i} ' class='current'>$i</a>"."\n" ;
					}else {
						$str .="<a href='{$this->pageUrl}={$i} '>$i</a>"."\n" ;
					}
				}
				$str.="<span class=\"dot\">……</span>"."\n";
				for($i=$this->totalPage-3+1; $i<=$this->totalPage; $i++){//功能1
                	$str .="<a href='{$this->pageUrl}={$i}' >$i</a>"."\n" ; 
		    	}            
			}elseif (5 < $this->pageIndex && $this->pageIndex <= $this->totalPage-5){
				for($i=1;$i<=3;$i++){
					$str .="<a href='{$this->pageUrl}={$i}' >$i</a>"."\n" ;
				}
				$str.="<span class=\"dot\">……</span>";	
				for($i=$this->pageIndex-1; $i<=$this->pageIndex+1 && $i<=$this->totalPage-5+1; $i++){
					if($this->pageIndex == $i) {
						$str .="<a href='{$this->pageUrl}={$i} ' class='current'>$i</a>"."\n" ;
					}else {
						$str .="<a href='{$this->pageUrl}={$i} '>$i</a>"."\n" ;
					}
				}	
				$str.="<span class=\"dot\">……</span>";
				for($i=$this->totalPage-3+1; $i<=$this->totalPage; $i++){
					$str .="<a href='{$this->pageUrl}={$i}' >$i</a>"."\n" ;		 
				}	 
			}else {
				for($i=1;$i<=3;$i++){       
					$str .="<a href='{$this->pageUrl}={$i}' >$i</a>"."\n" ;
				}
		        $str.="<span class=\"dot\">……</span>"."\n";
		        for($i=$this->totalPage-5; $i<=$this->totalPage; $i++){
		        	if($this->pageIndex == $i) {
						$str .="<a href='{$this->pageUrl}={$i} ' class='current'>$i</a>"."\n" ;
					}else {
						$str .="<a href='{$this->pageUrl}={$i} '>$i</a>"."\n" ;
					}
		        }
			}
		}

		if($this->pageIndex==$this->totalPage){	
		    $str .="\n"."<a href='javascript:void(0)' class='tips' title='下一页'>下一页</a>"."\n" ;
			$str .="<a href='javascript:void(0)' class='tips' title='末页'>末页</a>"."\n";
		}else{
		 	$str .="\n"."<a href='{$this->pageUrl}=".($this->pageIndex+1)."' class='tips' title='下一页'>下一页</a> "."\n";
			$str .="<a href='{$this->pageUrl}={$this->totalPage}' class='tips' title='末页'>末页</a> "."\n" ;
		}		
		
		$str .= "</div>";
		return $str;
	}

	static public function getInstance($totalPage, $pageIndex, $numPerPage) {
		if(is_null(self::$_instance)) {
			self::$_instance = new Page($totalPage, $pageIndex, $numPerPage);
		}
		return self::$_instance;
	}
}
?>












