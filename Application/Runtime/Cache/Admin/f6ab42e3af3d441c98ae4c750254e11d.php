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
        <h1 class="page-title">权限修改</h1>
    </div>

<!-- <?php if(is_array($_SESSION['top'])): $k = 0; $__LIST__ = $_SESSION['top'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vol_top): $mod = ($k % 2 );++$k;?><a href="#error-menu<?php echo ($k); ?>" class="nav-header collapsed" data-toggle="collapse"><i class="icon-exclamation-sign"></i><?php echo ($vol_top["auth_name"]); ?></a>
    <ul id="error-menu<?php echo ($k); ?>" class="nav nav-list collapse">
        <!-- 二级目录 -->
        <!-- <?php if(is_array($_SESSION['second'])): $key = 0; $__LIST__ = $_SESSION['second'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vol_second): $mod = ($key % 2 );++$key;?><!-- 判断显示二级目录的父id 等于顶级目录id  输出相应的二级目录-->
            <!-- <?php if($vol_second["pid"] == $vol_top["id"] ): ?><li><a href="/index.php/Admin/<?php echo ($vol_second["auth_c"]); ?>/<?php echo ($vol_second["auth_a"]); ?>"><?php echo ($vol_second["auth_name"]); ?></a></li><?php endif; endforeach; endif; else: echo "" ;endif; ?> -->
    <!-- </ul><?php endforeach; endif; else: echo "" ;endif; ?>  -->


    <div class="well">
        <!-- edit form -->
        <form id="tab" action="/index.php/Admin/Auth/edit/id/13" method="post">
            <input type="hidden" name="id" value="<?php echo ($data["id"]); ?>"></input>
            <label>权限名称：</label>
            <input type="text" name="auth_name" value="<?php echo ($data["auth_name"]); ?>" class="input-xlarge">
            <label>上级权限</label>
            <select name="pid" class="input-xlarge" value="<?php echo ($data["pid"]); ?>" >
                <option value='0'>作为顶级权限</option>
                <?php if(is_array($top)): $k = 0; $__LIST__ = $top;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vol): $mod = ($k % 2 );++$k;?><option value="<?php echo ($vol["id"]); ?>" <?php if(in_array(($vol["id"]), is_array($data["pid"])?$data["pid"]:explode(',',$data["pid"]))): ?>selected="selected"<?php endif; ?> ><?php echo ($vol["auth_name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
            </select>

            <div>
                <label>控制器：</label>
                <input type="text" name="auth_c" value="<?php echo ($data["auth_c"]); ?>" class="input-xlarge">
            </div>
            <div>
                <label>方法：</label>
                <input type="text" name="auth_a" value="<?php echo ($data["auth_a"]); ?>" class="input-xlarge">
            </div>
            <label>是否菜单项</label>
            <select name="is_nav" class="input-xlarge">
                <option value="1" <?php if(in_array(($data["is_nav"]), explode(',',"1"))): ?>selected="selected"<?php endif; ?> >是</option>
                <option value="0" <?php if(in_array(($data["is_nav"]), explode(',',"0"))): ?>selected="selected"<?php endif; ?> >否</option>
            </select>
            <label></label>
            <button class="btn btn-primary" type="submit">保存</button>
        </form>
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
<script src="/Public/Admin/js/jquery-1.8.1.min.js"></script>
<script src="/Public/Admin/js/bootstrap.min.js"></script>
<script>
$(function(){
    //当修改权限 展示旧数据时 要默认显示
      if (<?php echo ($data["pid"]); ?> == 0 ) {
        $("input[name=auth_c]").parent().hide();
        $("input[name=auth_a]").parent().hide();
      }     
    // $("input[name=auth_c]").parent().hide();
    // $("input[name=auth_a]").parent().hide();
    $("select[name=pid]").on('change', function(){
        if($(this).val() != 0){
            $("input[name=auth_c]").parent().show();
            $("input[name=auth_a]").parent().show();
        }else{
            $("input[name=auth_c]").parent().hide();
            $("input[name=auth_a]").parent().hide();
        }
    });
})
</script>
</html>