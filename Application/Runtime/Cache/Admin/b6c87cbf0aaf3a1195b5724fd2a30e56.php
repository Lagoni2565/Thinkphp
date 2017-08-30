<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
</head>
<body>
<hr>
系统变量：<br>

<hr>
    姓名：<?php echo ((isset($name) && ($name !== ""))?($name):'zhenzhen'); ?><br><!--没有传值设置默认-->
   	性别：<?php if( $person['sex'] == 1 ): ?>男<?php else: ?>女<?php endif; ?>

    <table border="1"  width="50%" rules="all">
    	<tr>
    		<td>遍历次数</td>
    		<td>ID</td>
    		<td>商品名称</td>
    		<td>添加时间</td>
    	</tr>
    	<?php if(is_array($data)): $k = 0; $__LIST__ = $data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vol): $mod = ($k % 2 );++$k;?><tr>
    			<td><?php echo ($k); ?></td>
    			<td><?php echo ($vol["id"]); ?></td>
    			<td><?php echo ($vol["goods_name"]); ?></td>
    			<td><?php echo (date("Y-m-d H:i:s",$vol["goods_time"])); ?></td>
    		</tr><?php endforeach; endif; else: echo "" ;endif; ?>
    </table>
</body>
</html>