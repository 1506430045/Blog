<?php if (!defined('THINK_PATH')) exit();?><div class="new">
    <span name="r_title">最热博文</span>
    <div class="r_blog" style="width:280px;">
        <ul>
        <?php if(is_array($hotBlog)): foreach($hotBlog as $key=>$v): ?><li><a href="<?php echo U('Index/blog',array('id'=>$v['id']));?>" style="overflow:hidden;"><?php echo ($v["title"]); ?></a><span name="r_time">(<?php echo (date('m-d H:i',$v["time"])); ?>)</span></li><?php endforeach; endif; ?>
        </ul>
    </div>
</div>