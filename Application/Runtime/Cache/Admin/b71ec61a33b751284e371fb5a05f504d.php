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
                        <i class="icon-user icon-white"></i> admin
                        <i class="icon-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a tabindex="-1" href="javascript:void(0);">修改密码</a></li>
                        <li class="divider"></li>
                        <li><a tabindex="-1" href="javascript:void(0);">安全退出</a></li>
                    </ul>
                </li>
            </ul>
            <a class="brand" href="javascript:void(0);"><span class="first">后台管理系统</span></a>
            <ul class="nav">
                <li class="active"><a href="javascript:void(0);">首页</a></li>
                <li><a href="javascript:void(0);">系统管理</a></li>
                <li><a href="javascript:void(0);">权限管理</a></li>
            </ul>
        </div>
    </div>
</div>
<!-- 左 -->
<div class="sidebar-nav">
    <a href="#error-menu" class="nav-header collapsed" data-toggle="collapse"><i class="icon-exclamation-sign"></i>权限管理</a>
    <ul id="error-menu" class="nav nav-list collapse">
        <li><a href="?m=Admin&c=Manager&a=Manager_list">管理员列表</a></li>
        <li><a href="?m=Admin&c=Manager&a=manager_add">管理员新增</a></li>
        <li><a href="?m=Admin&c=Manager&a=role_list">角色管理</a></li>
        <li><a href="?m=Admin&c=Manager&a=setauth">权限管理</a></li>
    </ul>
    <a href="#accounts-menu" class="nav-header" data-toggle="collapse"><i class="icon-exclamation-sign"></i>商品管理</a>
    <ul id="accounts-menu" class="nav nav-list collapse in">
        <li><a href="?m=Admin&c=Goods&a=index">商品列表</a></li>
        <li><a href="?m=Admin&c=Goods&a=add">商品新增</a></li>
        <li><a href="?m=Admin&c=Goods&a=type_list">商品类型</a></li>
        <li><a href="?m=Admin&c=Goods&a=type_list">商品分类</a></li>
    </ul>
    <a href="#accounts-menu" class="nav-header" data-toggle="collapse"><i class="icon-exclamation-sign"></i>订单管理</a>
    <ul id="accounts-menu" class="nav nav-list collapse">
        <li><a href="javascript:void(0);">订单列表</a></li>
        <li><a href="javascript:void(0);">订单新增</a></li>
    </ul>
    <a href="#accounts-menu" class="nav-header" data-toggle="collapse"><i class="icon-exclamation-sign"></i>会员管理</a>
    <ul id="accounts-menu" class="nav nav-list collapse">
        <li><a href="javascript:void(0);">用户列表</a></li>
        <li><a href="javascript:void(0);">用户新增</a></li>
    </ul>
    <a href="#dashboard-menu" class="nav-header" data-toggle="collapse"><i class="icon-exclamation-sign"></i>系统管理</a>
    <ul id="dashboard-menu" class="nav nav-list collapse">
        <li><a href="javascript:void(0);">密码修改</a></li>
    </ul>
</div>
<!-- 右 -->
<div class="content">
    <div class="header">
        <h1 class="page-title">商品新增</h1>
    </div>
    
    <!-- add form -->
    <form action="/index.php/Admin/Goods/add" method="post" id="tab" enctype="multipart/form-data">
        <ul class="nav nav-tabs">
          <li role="presentation" class="active"><a href="#basic" data-toggle="tab">基本信息</a></li>
          <li role="presentation"><a href="#desc" data-toggle="tab">商品描述</a></li>
          <li role="presentation"><a href="#attr" data-toggle="tab">商品属性</a></li>
          <li role="presentation"><a href="#pics" data-toggle="tab">商品相册</a></li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane fade in active" id="basic">
                <div class="well">
                    <label>商品名称：</label>
                    <input type="text" name="goods_name" value="" class="input-xlarge">
                    <label>商品价格：</label>
                    <input type="text" name="goods_price" value="" class="input-xlarge">
                    <label>商品数量：</label>
                    <input type="text" name="goods_number" value="" class="input-xlarge">
                    <label>商品logo：</label>
                    <input type="file" name="" value="" class="input-xlarge">
                </div>
            </div>
            <div class="tab-pane fade in" id="desc">
                <div class="well">
                    <label>商品简介：</label>
                    <textarea value="Smith" name="" rows="3" class="input-xlarge"></textarea>
                </div>
            </div>
            <div class="tab-pane fade in" id="attr">
                <div class="well">
                    <label>商品分类：</label>
                    <select name="" class="input-xlarge">
                        <option value="2">电脑</option>
                        <option value="1">手机</option>
                    </select>
                    <div>
                        <label>商品品牌：</label>
                        <input type="text" name="" value="" class="input-xlarge">
                        <label>商品型号：</label>
                        <input type="text" name="" value="" class="input-xlarge">
                        <label>商品重量：</label>
                        <input type="text" name="" value="" class="input-xlarge">
                    </div>
                </div>
            </div>
            <div class="tab-pane fade in" id="pics">
                <div class="well">
                        <div>[<a href="javascript:void(0);" class="add">+</a>]商品图片：<input type="file" name="goods_pics[]" value="" class="input-xlarge"></div>
                </div>
            </div>
            <button class="btn btn-primary" type="submit">保存</button>
        </div>
    </form>
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
<script type="text/javascript">
    $(function(){
        $('.add').click(function(){
            var add_div = '<div>[<a href="javascript:void(0);" class="sub">-</a>]商品图片：<input type="file" name="goods_pics[]" value="" class="input-xlarge"></div>';
            $(this).parent().after(add_div);
        });
        $('.sub').live('click',function(){
            $(this).parent().remove();
        });
    });
</script>
</html>