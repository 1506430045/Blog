<?php if (!defined('THINK_PATH')) exit();?><div class="nav">
    <ul>
        <li><a href="<?php echo U('/');?>">首页</a></li>
        <?php if(is_array($cate)): foreach($cate as $key=>$vo): ?><li><a href="<?php echo U('Index/cate',array('id'=>$vo['id']));?>"><?php echo ($vo["cname"]); ?></a></li><?php endforeach; endif; ?>
    </ul>
</div>