<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional搜索.dtd">
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>菜鸟PHPer -- 个人PHP技术博客</title>
    <link href="/blog/Public/css/base.css" rel="stylesheet" type="text/css" />

    <link href="/blog/Public/css/show.css" rel="stylesheet" type="text/css" />
    <link href="/blog/Public/Ueditor/third-party/SyntaxHighlighter/shCoreDefault.css" rel="stylesheet" type="text/css" />
	<script type="text/javascript" src="/blog/Public/Ueditor/third-party/SyntaxHighlighter/shCore.js"></script>  
	<script type="text/javascript">      
		SyntaxHighlighter.all();       
	</script>
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
			<div id="showContent">
				<div id="show_style" style="width:644px;margin:0 auto;">
                    <h1><?php echo ($blog[0]["title"]); ?></h1>
					<div id="topContent">
					    <span class="sharetime">时间:<?php echo (date('y/m/d',$blog[0]["time"])); ?> 分类:<?php echo ($blog[0]["cname"]); ?> 访问:<?php echo ($blog[0]["click"]); ?></span>
                        <div class="bdsharebuttonbox">
                            <a href="#" class="bds_more" data-cmd="more"></a>
                            <a href="#" class="bds_qzone" data-cmd="qzone" title="分享到QQ空间"></a>
                            <a href="#" class="bds_tsina" data-cmd="tsina" title="分享到新浪微博"></a>
                            <a href="#" class="bds_tqq" data-cmd="tqq" title="分享到腾讯微博"></a>
                            <a href="#" class="bds_renren" data-cmd="renren" title="分享到人人网"></a>
                            <a href="#" class="bds_weixin" data-cmd="weixin" title="分享到微信"></a>
                        </div>
                        <script>
                            window._bd_share_config={"common":{"bdSnsKey":{},"bdText":"","bdMini":"2","bdMiniList":false,"bdPic":"","bdStyle":"0","bdSize":"16"},"share":{},"image":{"viewList":["qzone","tsina","tqq","renren","weixin"],"viewText":"分享到：","viewSize":"16"},"selectShare":{"bdContainerClass":null,"bdSelectMiniList":["qzone","tsina","tqq","renren","weixin"]}};with(document)0[(getElementsByTagName('head')[0]||body).appendChild(createElement('script')).src='http://bdimg.share.baidu.com/static/api/js/share.js?v=89860593.js?cdnversion='+~(-new Date()/36e5)];
                        </script>
                    </div>
                    <div style="word-break:break-all;"><p id="neirong"><?php echo ($blog[0]["content"]); ?></p></div>
				</div>	
			</div>	
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
		<div class="f_warp">
    <div class="footer">
        <center>
            <br/>
            Copyright 2015-2015 菜鸟PHPer -- PHP技术博客,做成功的自己. Some Rights Reserved.<br/><br/>
            Design By 菜鸟PHPer | Powered By 菜鸟PHPer<br/><br/>
        </center>
    </div>
</div>
	</div>
</body>
</html>