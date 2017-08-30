<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>后台管理系统</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="">
<meta name="author" content="">
<link rel="stylesheet" type="text/css" href="/Public/Admin/css/main.css">
<link rel="stylesheet" type="text/css" href="/Public/Admin/css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="/Public/Admin/css/bootstrap-responsive.min.css">

</head>
<body>
<!-- 上 左-->
<!-- 上 -->
<div class="navbar">
    <div class="navbar-inner">
        <div class="container-fluid">
            <ul class="nav pull-right">
                <li id="fat-menu" class="dropdown">
                    <a href="#" id="drop3" role="button" class="dropdown-toggle" data-toggle="dropdown">
                        <i class="icon-user icon-white"></i>  <?php echo ($_SESSION['manager_info']['username']); ?> 
                        <i class="icon-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a tabindex="-1" href="/index.php/Admin/Index/repwd/id/<?php echo ($_SESSION['manager_info']['id']); ?>">修改密码</a></li>
                        <li class="divider"></li>
                        <li><a tabindex="-1" href="/index.php/Admin/Login/logout">安全退出</a></li>
                    </ul>
                </li>
            </ul>
            <a class="brand" href="/index.php/Admin/Index/index"><span class="first">后台管理系统</span></a>
            <ul class="nav">
                <li class="active"><a href="/index.php/Admin/Index/index">首页</a></li>
                <li><a href="javascript:void(0);">系统管理</a></li>
                <li><a href="javascript:void(0);">权限管理</a></li>
            </ul>
        </div>
    </div>
</div>
<!-- 左 -->
<div class="sidebar-nav">
<!-- 顶级目录 -->
    <?php if(is_array($_SESSION['top'])): $k = 0; $__LIST__ = $_SESSION['top'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vol_top): $mod = ($k % 2 );++$k;?><a href="#error-menu<?php echo ($k); ?>" class="nav-header collapsed" data-toggle="collapse"><i class="icon-exclamation-sign"></i><?php echo ($vol_top["auth_name"]); ?></a>
    <ul id="error-menu<?php echo ($k); ?>" class="nav nav-list collapse">
        <!-- 二级目录 -->
        <?php if(is_array($_SESSION['second'])): $key = 0; $__LIST__ = $_SESSION['second'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vol_second): $mod = ($key % 2 );++$key;?><!-- 判断显示二级目录的父id 等于顶级目录id  输出相应的二级目录-->
            <?php if($vol_second["pid"] == $vol_top["id"] ): ?><li><a href="/index.php/Admin/<?php echo ($vol_second["auth_c"]); ?>/<?php echo ($vol_second["auth_a"]); ?>"><?php echo ($vol_second["auth_name"]); ?></a></li><?php endif; endforeach; endif; else: echo "" ;endif; ?>
         <!-- 二级目录结束 -->
        <!-- <li><a href="/index.php/Admin/Manager/add">管理员新增</a></li>
        <li><a href="/index.php/Admin/Setauth/index">角色管理</a></li>
        <li><a href="/index.php/Admin/Setauth/setauth">权限管理</a></li> -->
    </ul><?php endforeach; endif; else: echo "" ;endif; ?>
<!-- 顶级目录结束 -->

    <!-- <a href="#accounts-menu" class="nav-header" data-toggle="collapse"><i class="icon-exclamation-sign"></i>商品管理</a>
    <ul id="accounts-menu" class="nav nav-list collapse in">
        <li><a href="/index.php/Admin/Goods/index">商品列表</a></li>
        <li><a href="/index.php/Admin/Goods/add">商品新增</a></li>
        <li><a href="/index.php/Admin/Type/index">商品类型</a></li>
        <li><a href="/index.php/Admin/Type/add">商品分类</a></li>
    </ul>
    <a href="#1accounts-menu" class="nav-header" data-toggle="collapse"><i class="icon-exclamation-sign"></i>订单管理</a>
    <ul id="1accounts-menu" class="nav nav-list collapse">
        <li><a href="javascript:void(0);">订单列表</a></li>
        <li><a href="javascript:void(0);">订单新增</a></li>
    </ul>
    <a href="#2accounts-menu" class="nav-header" data-toggle="collapse"><i class="icon-exclamation-sign"></i>会员管理</a>
    <ul id="2accounts-menu" class="nav nav-list collapse">
        <li><a href="javascript:void(0);">用户列表</a></li>
        <li><a href="javascript:void(0);">用户新增</a></li>
    </ul>
    <a href="#dashboard-menu" class="nav-header" data-toggle="collapse"><i class="icon-exclamation-sign"></i>系统管理</a>
    <ul id="dashboard-menu" class="nav nav-list collapse">
        <li><a href="javascript:void(0);">密码修改</a></li>
    </ul> -->
</div>
<!-- 右 -->
<div class="content">
    <div class="header">
        <h1 class="page-title">商品详情</h1>
    </div>

    <div class="well">
        <label>商品名称：</label>
        <div><?php echo ($goods["goods_name"]); ?></div>
        <label>商品价格：</label>
        <div><?php echo ($goods["goods_price"]); ?></div>   
        <label>商品数量：</label>
        <div><?php echo ($goods["goods_number"]); ?></div>
        <label>商品图片：</label>
        <div><img src="<?php echo ($goods["goods_small_img"]); ?>"></div>
        <label>商品简介：</label>
        <div><?php echo ($goods["goods_introduce"]); ?></div>
        <label>销售额</label>
        <div id="container" style="min-width:400px;height:400px"></div>
    </div>
    <!-- footer -->
    <footer>
        <hr>
        <p>© 2017 <a href="javascript:void(0);" target="_blank">ADMIN</a></p>
    </footer>
</div>
</body>
<!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
<!--[if lt IE 9]>
  <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->
<script src="/Public/Admin/jss/jquery-1.8.1.min.js"></script>
<script src="/Public/Admin/jss/bootstrap.min.js"></script>

<!--引入外部JS文件—-->
<script src="/Public/Admin/highcharts/highcharts.js"></script>
<script src="/Public/Admin/highcharts/modules/exporting.js"></script>
<script>
	/**
  * Highcharts 在 4.2.0 开始已经不依赖 jQuery 了，直接用其构造函数既可创建图表
 **/
var chart = new Highcharts.Chart('container', {
    title: {
        text: '销售额',
        x: -20
    },
    subtitle: {
        text: '数据来源: www.tpshop.com',
        x: -20
    },
    xAxis: {
        categories: ['一月', '二月', '三月', '四月', '五月']
    },
    yAxis: {
        title: {
            text: '销售额 (万元)'
        },
        plotLines: [{
            value: 0,
            width: 1,
            color: '#808080'
        }]
    },
    tooltip: {
        valueSuffix: '万元'
    },
    legend: {
        layout: 'vertical',
        align: 'right',
        verticalAlign: 'middle',
        borderWidth: 0
    },
    series:<?php echo ($json_data); ?>
});
/**经观察 series值 为 数组形式的字符串
需要从后台获取 数组形式的json字符串


*/
</script>

</html>