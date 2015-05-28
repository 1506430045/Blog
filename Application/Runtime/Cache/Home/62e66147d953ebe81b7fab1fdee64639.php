<?php if (!defined('THINK_PATH')) exit();?><div class="new">
    <span name="r_title">随笔档案</span>
    <div class="r_blog" style="width:280px;">
        <ul>
        <?php if(is_array($yearAndMonth)): foreach($yearAndMonth as $key=>$v): ?><li><a href="<?php echo U('Search/suibi',array('y'=>$v['year'],'m'=>$v['month']));?>"><?php echo ($v["year"]); ?>年<?php echo ($v["month"]); ?>月(<?php echo ($v["num"]); ?>)</a></li><?php endforeach; endif; ?>
        </ul>
    </div>
</div>