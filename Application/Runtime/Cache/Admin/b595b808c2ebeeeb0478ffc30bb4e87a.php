<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional搜索.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> 
<link rel="stylesheet" type="text/css" href="/blog/Public/css/admin/base.css" />
<link rel="stylesheet" type="text/css" href="/blog/Public/css/admin/index.css" />
<script type="text/javascript">

	// function addEventHandler(target, type, func) {
	// 	if (target.addEventListener) {
	// 		//IE9,chorme,FF
	// 		target.addEventListener(type, func, false);
	// 	} else if(target.attachEvent) {
	// 		target.attachEvent("on" + type, func);
	// 	} else {
	// 		target["on" + type] = func;
	// 	}
	// }

	window.onload = function() {
		function $(id) {
			return document.getElementById(id);
		};

		function getClass(tagName, className) {
			if (document.getElementsByClassName) {
				return document.getElementsByClassName(className);
			} else {
				var tags = document.getElementsByTagName(tagName);
				var tagArr = [];
				for(var i=0; i<tags.length; i++) {
					if (tags[i].className == className) {
						tagArr[tagArr.length] = tags[i]; 
					}
				}
				return tagArr;
			}
		};

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

		$('add_user').onclick = function() {
			showDiv('addUser');
		};
		// //addEventHandler($('add_user'), 'click', showAddUser);

		var updUserArr = getClass('a', 'upd_user');
		for(var i=0; i<updUserArr.length; i++) {
			updUserArr[i].onclick = function() {
				showDiv('updUser');
				document.getElementById('user').value = '123';
				document.getElementById('pass').value = '123';
				document.getElementById('repass').value = '123';
			}
		};

		$('closeAddUser').onclick = function() {
			$('layer_bg').style.display = 'none';
			$('addUser').style.display = 'none';
		};

		$('closeUpdUser').onclick = function() {
			$('layer_bg').style.display = 'none';
			$('updUser').style.display = 'none';
		};
	};

	function getAllCheck(obj) {
		var myCheck = document.getElementsByName('myCheck');
		for (var i = myCheck.length - 1; i > 0; i--) {
			if (myCheck[i].checked != obj.checked) {
				myCheck[i].checked = obj.checked;
			}
		}
	}
</script>
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

		</div>
		<div id="right">
			<div id="r_top">
				<p>尊敬的管理员，欢迎登录『菜鸟PHPER』管理后台。</p>
			</div>
			<div id="r_kuaijie">
				<h1>快捷操作</h1>
				<div id="r_nav">
					<a href="#" id="add_user">新增用户</a>
					<a href="">批量禁用</a>
					<a href="">批量删除</a>
				</div>
			</div>
			<div id="result_content">
				<form action="" method="post">
					<table width="100%" cellpadding="0" cellspacing="0">
					<tbody>
						<tr>
							<th name="first">
								<input type="checkbox" name="myCheck" onclick="getAllCheck(this);" />
							</th>
							<th name="other">ID</th>
							<th name="other">用户名</th>
							<th name="other">登录时间</th>
							<th name="other">登录IP</th>
							<th name="other">角色</th>
							<th name="other">操作</th>
						</tr>
						<?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
								<td name="first"><input type="checkbox" name="myCheck" /></td>
								<td name="other"><?php echo ($vo["id"]); ?></td>
								<td name="other"><?php echo ($vo["username"]); ?></td>
								<td name="other"><?php echo (date("Y-m-d H:i",$vo["logintime"])); ?></td>
								<td name="other"><?php echo ($vo["loginip"]); ?></td>
								<td name="other">
									<?php if($vo["role"] == 1): ?><font style="color:red;font-weight:bold;">超级管理员</font>
									<?php else: ?>
										普通管理员<?php endif; ?>
								</td>
								<td name="other">
									<a href="#" class="upd_user">[修改]</a>
									<?php if($vo["role"] == 0): ?>&nbsp;<a href="">[禁用]</a>
										&nbsp;<a href="">[删除]</a><?php endif; ?>
								</td>
							</tr><?php endforeach; endif; else: echo "" ;endif; ?>
					</tbody>
				</table>
				</form>
			</div>
		</div>
	</div> 
	<div class="layer_bg" id="layer_bg"></div>
	<!--新增manager弹窗-->
	<div class="layer" id="addUser">
		<h1>新增用户</h1>
		<p class="center"><button id="closeAddUser">关闭</button></p>
		<div id="addTable">
			<form action="<?php echo U('Index/addManager');?>" method="post">
				<label>
					<span>账号：</span><input type="text" name="username" />
				</label><br/>
				<label>
					<span>密码：</span><input type="text" name="password" />
				</label><br/>
				<label>
					<span>重复密码：</span><input type="text" name="repass" />
				</label><br/>
				<label>
					<span name="role">角色：</span>
					<select style="height:30px;" name="role">
						<option value="0">普通管理员</option>
						<option value="1">超级管理员</option>
					</select>
				</label>
				<br/>
				<label name="subLabel">
					<input type="submit" name="sub" value="添加" />
				</label>
			</form>
		</div>
	</div>
	<!--修改manager弹窗-->
	<div class="layer" id="updUser">
		<h1>修改用户</h1>
		<p class="center"><button id="closeUpdUser">关闭</button></p>
		<div id="addTable">
			<form action="<?php echo U('Index/updManager');?>" method="post">
				<label>
					<span>账号：</span><input type="text" name="username" id="user" readonly="readonly" />
				</label><br/>
				<label>
					<span>密码：</span><input type="text" id="pass" name="password" />
				</label><br/>
				<label>
					<span>重复密码：</span><input type="text" id="repass" name="repass" />
				</label><br/>
				<label>
					<span name="role">角色：</span>
					<select name="role" id="role">
						<option value="0">普通管理员</option>
						<option value="1">超级管理员</option>
					</select>
				</label>
				<br/>
				<label name="subLabel">
					<input type="submit" name="sub" value="修改" />
				</label>
			</form>
		</div>
	</div>
</body>
</html>