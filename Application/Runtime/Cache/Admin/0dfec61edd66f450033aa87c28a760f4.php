<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional搜索.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> 
<link rel="stylesheet" type="text/css" href="/blog/Public/css/admin/login.css">
<script type="text/javascript" src="/blog/Public/js/jquery-1.7.2.min.js"></script>
<script type="text/javascript">
	function change_verify(obj) {
		var URL = "<?php echo U('/Admin/Login/verify');?>/";
		$("#verify").attr("src",URL+Math.random());
	}
</script>
<title>菜鸟PHPer -- 登录</title>
</head>
<body>
<div class="login_box">
	<form class="loginForm" action="<?php echo U('Admin/Login/doLogin');?>" method="post">
		<h3>菜鸟PHPer -- 登录</h3>
		<div>
			<label>UserName:</label>
			<input type="text" name="username" />
		</div>
		<div>
			<label>PassWord:</label>
			<input type="password" name="password" />
		</div>
		<div>
			<label>Verify:</label>
			<input type="password" name="verify" />
			<img src="<?php echo U('/Admin/Login/verify');?>" id="verify" onclick="change_verify(this);" width="96px" height="26px" style="margin-top:6px;" />
		</div>
		<div id="bottom">
			<input type="submit" name="sub" value="登录" />
		</div>
	</form>
</div>
</body>
</html>