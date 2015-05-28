<?php if (!defined('THINK_PATH')) exit();?><div class="new">
    <span name="r_title">我的标签</span>
    <div class="r_blog" style="width:280px;padding-top:10px;">
    <?php if(is_array($tag)): foreach($tag as $key=>$v): ?><a href="<?php echo U('Index/getBlogByTag',array('id'=>$v['id']));?>">
            <div style="color: <?php echo ($v['color']); ?>" class="tagshow"><?php echo ($v["name"]); ?></div>
        </a><?php endforeach; endif; ?>
    </div>
</div>