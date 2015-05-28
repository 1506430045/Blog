<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional搜索.dtd">
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>菜鸟PHPer -- 个人PHP技术博客</title>
    <link href="/blog/Public/css/base.css" rel="stylesheet" type="text/css" />

    <link href="/blog/Public/css/index.css" rel="stylesheet" type="text/css" />
    </head>
<script type="text/javascript">
    function inputFoucs(obj) {
		if(obj.value == '来点什么。。。'){
			obj.value = '';
		}
    }

    function inputBlur(obj) {
		if(obj.value == '') {
			obj.value = '来点什么。。。';
		}
    }
</script>
<body>
<div class="header">
    <div class="h_warp">
        <div class="header_1">
            <a href="http://laravel-china.github.io/php-the-right-way/" target="_blank">
                <img src="/blog/Public/img/btn1-120x90.png" width="160px" height="100px" alt="PHP: The Right Way" />
            </a>
        </div>
        <div class="header_2">
            <br/>
            <br/>
            <font>个人PHP技术博客<br/>用于记录平时所学<菜鸟>。。。。。</font>
        </div>
        <div class="header_3">
            <form action="<?php echo U('Search/search');?>" method="post" id="searchForm">
                <input type="text" name="keyword" value="来点什么。。。" onblur="inputBlur(this);" onfocus="inputFoucs(this);" />
            </form>
            <a class="search" onclick="document.getElementById('searchForm').submit();">搜 索</a>
        </div>
    </div>
</div>
<div class="n_warp">
    <?php echo W('Nav/nav');?>
</div>

    <div class="warp">
		<div class="left">
            <?php if(is_array($blog)): foreach($blog as $k=>$vo): ?><div id="cate_1">
                    <span id="c_title">&nbsp;&nbsp;<?php echo ($vo["cname"]); ?></span>
                    <span id="c_more"><a href="<?php echo U('Index/cate',array('id'=>$vo['cateid']));?>">更多>>&nbsp;&nbsp;</a></span>
                    <div id="box">
                        <ul>
                            <?php if(is_array($vo["blog"])): foreach($vo["blog"] as $key=>$v): ?><li><a href="<?php echo U('Index/blog',array('id'=>$v['id']));?>" style="overflow: hidden;"><?php echo ($v["title"]); ?></a><span><?php echo (date('y/m/d',$v["time"])); ?>&nbsp;</span></li><?php endforeach; endif; ?>
                        </ul>
                    </div>
                </div><?php endforeach; endif; ?>
		</div>	
		<div class="right">
    <div class="cale">
        <center>
            <?php echo W('Right/cale');?>
        </center>
    </div>
    <?php echo W('Right/tag');?>
    <?php echo W('Right/newBlog');?>
    <?php echo W('Right/hotBlog');?>
    <?php echo W('Right/randomBlog');?>
    <?php echo W('Right/suibi');?>
</div>
	</div>
	<div class="f_warp">
    <div class="footer">
        <center>
            <br/>
            Copyright 2015-2015 菜鸟PHPer -- PHP技术博客,做成功的自己. Some Rights Reserved.<br/><br/>
            Design By 菜鸟PHPer | Powered By 菜鸟PHPer<br/><br/>
        </center>
    </div>
</div>
</body>
</html>