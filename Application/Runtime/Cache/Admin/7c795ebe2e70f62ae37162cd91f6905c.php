<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional搜索.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> 
<link rel="stylesheet" type="text/css" href="/blog/Public/css/admin/base.css" />
<link rel="stylesheet" type="text/css" href="/blog/Public/css/admin/tag.css" />
<script type="text/javascript">
	function getAllCheck(obj) {
		var myCheck = document.getElementsByName('myCheck');
		for (var i = myCheck.length - 1; i >= 0; i--) {
			if (myCheck[i].checked != obj.checked) {
				myCheck[i].checked = obj.checked;
			};
		};
	}

    function getAllChecked() {
        var myCheck = document.getElementsByName('myCheck');
        var myCheckedStr = '';
        for(var i=0;i<myCheck.length;i++) {
            if(myCheck[i].checked == true) {
                myCheckedStr += myCheck[i].value+',';
            }
        }
        return myCheckedStr;
    }

    function delAllCheckedTag() {
        var xmlhttp = getXhrObj();
        xmlhttp.onreadystatechange = function() {
            if(xmlhttp.readyState==4 && xmlhttp.status==200) {
                var json = eval("(" + xmlhttp.responseText + ")");
                if(json.status == 'success') {
                    window.location.reload();
                } else {
                    alert(json.msg);
                }
            }
        }
        xmlhttp.open("POST","<?php echo U('Tag/delAllCheckedTag');?>",true);
        xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
        xmlhttp.send("checkedStr="+getAllChecked());
    }

    function getXhrObj() {
        if(window.XMLHttpRequest) {
            xmlhttp = new XMLHttpRequest();
        } else {
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        return xmlhttp;
    }

    function getUpdTag(obj) {
        var val = obj.parentNode.parentNode.childNodes[3];
        val = val.innerText;
        var width = document.body.clientWidth;
        var height = document.body.clientHeight;
        document.getElementById('layer_bg').style.width=width+'px';
        document.getElementById('layer_bg').style.height=height+'px';
        document.getElementById('layer_bg').style.display='block';
        document.getElementById('updTag').style.display = 'block';

        var xmlhttp = getXhrObj();
        xmlhttp.onreadystatechange = function() {
            if(xmlhttp.readyState==4 && xmlhttp.status==200) {
                var json = eval("(" + xmlhttp.responseText + ")");
                if(json.status == 'success') {
                    var tableDiv = document.getElementById("updTagTable");
                    var inputName = tableDiv.getElementsByTagName('input');
                    inputName[0].value = json["0"].name;
                    inputName[1].value = json["0"].color.substr(1);
                } else {
                    alert(json.status);
                }
            }
        }
        xmlhttp.open("POST","<?php echo U('Tag/selTag');?>",true);
        xmlhttp.setRequestHeader("Content-type","application/x-www-form-urlencoded");
        xmlhttp.send("id="+val);
    }

	window.onload = function() {
		function $(id) {
			return document.getElementById(id);
		}

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
        }

		function showBg() {
			var width = document.body.clientWidth;
			var height = document.body.clientHeight;
			$('layer_bg').style.width=width+'px';
			$('layer_bg').style.height=height+'px';
			$('layer_bg').style.display='block';
		}

		function showDiv(id) {
			showBg();
			$(id).style.display = 'block';
		}

		$('add_tag').onclick = function() {
			showDiv('addTag');
		}

		$('closeAddTag').onclick = function() {
			$('layer_bg').style.display = 'none';
			$('addTag').style.display = 'none';
		}

        $('closeUpdTag').onclick = function() {
            $('layer_bg').style.display = 'none';
            $('updTag').style.display = 'none';
        }
	}
</script>
<script type="text/javascript" src="/blog/Public/js/jscolor/jscolor.js"></script>
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
					<a href="#" id="add_tag">新增标签</a>
					<a href="#" onclick="javascript:if(confirm('你确定要删除所选Tag么？')) delAllCheckedTag();">批量删除</a>
				</div>
			</div>
			<div id="result_content">
				<form action="" method="post">
					<table width="100%" cellpadding="0" cellspacing="0">
					<tbody>
						<tr>
							<th name="first">
								<input type="checkbox" onclick="javascript:getAllCheck(this);" />
							</th>
							<th name="other">ID</th>
							<th name="other">标签名称</th>
							<th name="other">标签颜色</th>
							<th name="other">操作</th>
						</tr>
						<?php if(is_array($tags)): $i = 0; $__LIST__ = $tags;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
								<td name="first"><input type="checkbox" name="myCheck" value="<?php echo ($vo["id"]); ?>" /></td>
								<td name="other"><?php echo ($vo["id"]); ?></td>
								<td name="other" style="color:<?php echo ($vo["color"]); ?>;font-weight:bold;"><?php echo ($vo["name"]); ?></td>
								<td name="other">
									<div id="tagColor" style="margin-left:20px;width:20px;height:20px;background:<?php echo ($vo["color"]); ?>"></div>
								</td>
								<td name="other">
									<a href="#" class="upd_tag" onclick="javascript:getUpdTag(this)">[修改]</a>
									&nbsp;<a href="<?php echo U('Tag/delTag',array('id'=>$vo['id']));?>" class="del" onclick="javascript:if(confirm('你确定要删除该Tag么？')) return true;return false;">[删除]</a>
								</td>
							</tr><?php endforeach; endif; else: echo "" ;endif; ?>
					</tbody>
				</table>
				</form>
			</div>
		</div>
	</div>
	<div class="layer_bg" id="layer_bg"></div>
	<!--新增Tag弹窗-->
	<div class="layer" id="addTag">
		<h1>新增标签</h1>
		<p class="center"><button id="closeAddTag">关闭</button></p>
		<div class="addTable">
			<form action="<?php echo U('Tag/addTag');?>" method="post">
				<label>
					<span>标签名称：</span><input type="text" name="tagname" />
				</label><br/>
				<label>
					<span>标签颜色：</span><input type="text" name="color" class="color" />
				</label><br/>
				<br/>
				<label name="subLabel">
					<input type="submit" name="sub" value="添加" />
				</label>
			</form>
		</div>
	</div>
    <!--修改Tag弹窗-->
    <div class="layer" id="updTag">
        <h1>修改标签</h1>
        <p class="center"><button id="closeUpdTag">关闭</button></p>
        <div class="addTable">
            <form action="<?php echo U('Tag/updTag');?>" method="post" id="updTagTable">
                <label>
                    <span>标签名称：</span><input type="text" name="tagname" />
                </label><br/>
                <label>
                    <span>标签颜色：</span><input type="text" name="color" class="color" />
                </label><br/>
                <br/>
                <label name="subLabel">
                    <input type="submit" name="sub" value="修改" />
                </label>
            </form>
        </div>
    </div>
</body>
</html>