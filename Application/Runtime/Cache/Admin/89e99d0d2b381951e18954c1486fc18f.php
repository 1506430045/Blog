<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional搜索.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> 
<link rel="stylesheet" type="text/css" href="/blog/Public/css/admin/base.css" />
<link rel="stylesheet" type="text/css" href="/blog/Public/css/admin/blog.css" />
<link rel="stylesheet" type="text/css" href="/blog/Public/css/admin/pager.css" />
<script type="text/javascript">
	function getAllCheck(obj) {
		var myCheck = document.getElementsByName('myCheck');
		for (var i = myCheck.length - 1; i > 0; i--) {
			if (myCheck[i].checked != obj.checked) {
				myCheck[i].checked = obj.checked;
			};
		};
	};

	//UEDITOR_HOME_URL、config、all这三个顺序不能改变
	window.onload = function() {
		// Ueditor初始化
		//编辑器的宽度
		window.UEDITOR_CONFIG.initialFrameWidth=775;
		//编辑器的高度
		window.UEDITOR_CONFIG.initialFrameHeight=450;
		//图片上传提交地址
		//window.UEDITOR_CONFIG.imageUrl="<?php echo U(GROUP_NAME.'/Blog/upload');?>"; 
		//编辑器调用图片的地址
        window.UEDITOR_HOME_URL = "/blog/Public/Ueditor/";
		window.UEDITOR_CONFIG.savePath= ['Uploads'];
        window.UEDITOR_CONFIG.imagePath = '/blog/Uploads/';
		UE.getEditor("content");

		function $(id) {
			return document.getElementById(id);
		}

		function showBg() {
			var width = document.body.clientWidth;
			var height = document.body.clientHeight;
			$('layer_bg').style.width=width+'px';
			$('layer_bg').style.height=height+'px';
			$('layer_bg').style.display='block';
		};	

		function showDiv(id) {
			showBg();
			$(id).style.display = 'block';
		};

		$('add_blog').onclick = function() {
			showDiv('addBlog');
		}

		$('closeAddBlog').onclick = function() {
			$('layer_bg').style.display = 'none';
			$('addBlog').style.display = 'none';
		}

	};
</script>
<script type="text/javascript" src="/blog/Public/Ueditor/ueditor.config.js"></script>
<script type="text/javascript" src="/blog/Public/Ueditor/ueditor.all.min.js"></script>
<title>菜鸟PHPer -- 后台管理</title>
</head>
<body>
	<div id="header">
	<div id="h_left">
		<ul>
			<li><a href="<?php echo U('Index/index');?>" name="shouye">首页</a></li>
			<li><a href="<?php echo U('/');?>" target="_blank">网站首页</a></li>
		</ul>
	</div>
	<div id="h_right">
		<ul>
			<li><a href="<?php echo U('Index/index');?>">管理员</a></li>
			<li><a href="">修改密码</a></li>
			<li><a href="<?php echo U('Login/logout');?>">退出</a></li>
		</ul>
	</div>
</div>
	<div class="content">
		<div id="left">
	<h1>菜单</h1>
	<dl>
		<dt>常用操作</dt>
		<dd><a href="<?php echo U('Tag/index');?>">标签管理</a></dd>
		<dd><a href="<?php echo U('Blog/index');?>">博文管理</a></dd>
		<dd><a href="<?php echo U('Cate/index');?>">分类管理</a></dd>
		<dt>系统管理</dt>
		<dd><a href="<?php echo U('Index/index');?>">用户管理</a></dd>
		<dd><a href="">系统设置</a></dd>
		<dd><a href="<?php echo U('Index/flush');?>">清除缓存</a></dd>
	</dl>
</div>

		<div id="right">
			<div id="r_top">
				<p>尊敬的管理员，欢迎登录『菜鸟PHPER』管理后台。</p>
			</div>
			<div id="r_kuaijie">
				<h1>快捷操作</h1>
				<div id="r_nav">
					<a href="#" id="add_blog">新增博文</a>
					<a href="#">批量删除</a>
					<a href="<?php echo U('Blog/index',array('recycle'=>1));?>">回收站</a>
                    <select name="searchCate" id="cateOptions">
                        <option>++分类检索++</option>
                        <option value="0">所有分类</option>
                        <?php if(is_array($cates)): foreach($cates as $key=>$v): ?><option value="<?php echo ($v["id"]); ?>"><?php echo ($v["cname"]); ?></option><?php endforeach; endif; ?>
                    </select>
				</div>
			</div>
			<div id="result_content">
				<form action="" method="post">
					<table width="100%" cellpadding="0" cellspacing="0">
					<tbody>
						<tr>
							<th name="first">
								<input type="checkbox" name="myCheck" onclick="javascript:getAllCheck(this);" />
							</th>
							<th name="other">ID</th>
							<th name="other">博文标题</th>
							<th name="other">所属分类</th>
							<th name="other">对应标签</th>
							<th name="other">发布时间</th>
							<th name="other">点击量</th>
							<th name="other">操作</th>
						</tr>
						<?php if(is_array($blogs)): $i = 0; $__LIST__ = $blogs;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
								<td name="first"><input type="checkbox" name="myCheck" /></td>
								<td name="other"><?php echo ($vo["id"]); ?></td>
								<td name="other"><a href="<?php echo U('Home/Index/blog',array('id'=>$vo['id']));?>" target="_blank"><?php echo ($vo["title"]); ?></a></td>
								<td name="other"><?php echo ($vo["cname"]); ?></td>
								<td name="other">
									<?php if(is_array($vo["tags"])): foreach($vo["tags"] as $key=>$tag): ?><font style="color:<?php echo ($tag["color"]); ?>;font-weight:bold;"><?php echo ($tag["name"]); ?>&nbsp;</font><?php endforeach; endif; ?>
								</td>
								<td name="other"><?php echo (date("Y-m-d H:i",$vo["time"])); ?></td>
								<td name="other"><?php echo ($vo["click"]); ?></td>
								<td name="other">
                                    <?php if($recycle != 0): ?><a href="<?php echo U('Blog/delBlog',array('id'=>$vo['id']));?>">[彻底删除]</a>
                                    <?php else: ?>
                                        <a href="#">[修改]</a>
                                        <a href="<?php echo U('Blog/delBlog',array('id'=>$vo['id']));?>">[删除]</a><?php endif; ?>
								</td>
							</tr><?php endforeach; endif; else: echo "" ;endif; ?>
                        <tr>
                           <td colspan="8" style="text-align: right;padding-right: 10px;">
                               <?php echo ($page); ?>
                           </td>
                        </tr>
					</tbody>
				</table>
				</form>
			</div>
		</div>
	</div>
	<div class="layer_bg" id="layer_bg"></div>
	<!--新增Blog-->
	<div class="layer" id="addBlog">
		<h1>新增博文</h1>
		<p class="center"><button id="closeAddBlog">关闭</button></p>
		<div id="addTable">
			<form action="<?php echo U('Blog/addBlog');?>" method="post">
				<table cellspacing="0" cellpadding="0">
				<tbody>
					<tr>
						<td class="left">博文标题：</td>
						<td><input type="text" name="title" /></td>
					</tr>	
					<tr>
						<td class="left">博文分类：</td>
						<td>
							<select name="cate">
								<?php if(is_array($cates)): foreach($cates as $key=>$v): ?><option value="<?php echo ($v["id"]); ?>"><?php echo ($v["cname"]); ?></option><?php endforeach; endif; ?>
							</select>
						</td>
					</tr>
					<tr>
						<td class="left">博文标签：</td>
						<td>
							<?php if(is_array($tags)): foreach($tags as $key=>$v): ?><input type="checkbox" name="tags[]" value="<?php echo ($v["id"]); ?>"><?php echo ($v["name"]); ?> &nbsp;<?php endforeach; endif; ?>
						</td>
					</tr>
					<tr>
						<td class="left">博文点击量：</td>
						<td><input type="text" name="click" value="100" /></td>
					</tr>	
					<tr>
						<td class="left">博文内容：</td>
						<td><textarea name="content" id="content"></textarea></td>
					</tr>
					<tr>
						<td colspan="2" class="sub">
							<input type="submit" value='添加博文' />
						</td>
					</tr>
				</tbody>
				</table>
			</form>
		</div>
	</div>
</body>
<script type="text/javascript">
    var cateOptions = document.getElementById("cateOptions");
    cateOptions.onchange = function() {
        var index = cateOptions.options[cateOptions.selectedIndex].value;
        var url = "<?php echo U('Blog/index');?>/cate/"+index;
        location.href = url;
    }
</script>
</html>