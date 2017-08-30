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
                    <input type="text" name="name" value="" class="input-xlarge">
                    <label>商品价格：</label>
                    <input type="text" name="price" value="" class="input-xlarge">
                    <label>商品数量：</label>
                    <input type="text" name="number" value="" class="input-xlarge">
                    <label>商品logo：</label>
                    <input type="file" name="logo" value="" class="input-xlarge">
                    <label>商品分类：</label>
                    <select name="cate_id">
                        <option value="0">==请选择==</option>
                        <?php if(is_array($category)): $i = 0; $__LIST__ = $category;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$cate): $mod = ($i % 2 );++$i;?><option value="<?php echo ($cate["id"]); ?>"><?php echo ($cate["cate_name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?> 
                    </select>
                </div>
            </div>
            <div class="tab-pane fade in" id="desc">
                <div class="well">
                    <label>商品简介：</label>
                    <textarea id="ueditor" name="goods_introduce"   style="width:100% ; height:300px" ></textarea>
                </div>
            </div>
            <div class="tab-pane fade in" id="attr">
                <div class="well">
                    <label>商品类型：</label>
                    <select name="type_id" class="input-xlarge">
                            <option value="0" >==请选择==</option>
                        <?php if(is_array($type)): $i = 0; $__LIST__ = $type;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vol): $mod = ($i % 2 );++$i;?><option value="<?php echo ($vol["type_id"]); ?>"><?php echo ($vol["type_name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                    </select>
                    <div id="attr_value">
                        <!-- <label>商品品牌：</label>
                        <input type="text" name="" value="" class="input-xlarge">
                        <label>商品型号：</label>
                        <input type="text" name="" value="" class="input-xlarge">
                        <label>商品重量：</label>
                        <input type="text" name="" value="" class="input-xlarge"> -->
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
<script type="text/javascript" charset="utf-8" src="/Public/Admin/ueditor/ueditor.config.js"></script>
<script type="text/javascript" charset="utf-8" src="/Public/Admin/ueditor/ueditor.all.min.js"> </script>
    <!--建议手动加在语言，避免在ie下有时因为加载语言失败导致编辑器加载失败-->
    <!--这里加载的语言文件会覆盖你在配置项目里添加的语言类型，比如你在配置项目里配置的是英文，这里加载的中文，那最后就是中文-->
 <script type="text/javascript" charset="utf-8" src="/Public/Admin/ueditor/lang/zh-cn/zh-cn.js"></script>


<script src="/Public/Admin/js/jquery-1.8.1.min.js"></script>
<script src="/Public/Admin/js/bootstrap.min.js"></script>
<script type="text/javascript">

    //实例化编辑器
    //建议使用工厂方法getEditor创建和引用编辑器实例，如果在某个闭包下引用该编辑器，直接调用UE.getEditor('editor')就能拿到相关的实例
    

    $(function(){
       var ue = UE.getEditor('ueditor'); 
       // 先给 + 号 绑定一个点击事件  在当前行的下方 添加一个DIV 
        $('.add').click(function(){
            var add_div = '<div>[<a href="javascript:void(0);" class="sub">-</a>]商品图片：<input type="file" name="goods_pics[]" value="" class="input-xlarge"></div>';
            $(this).parent().after(add_div);
        });

        //给 - 号 给后来 通过js  添加的 元素 要使用 live 进行绑定事件
        $('.sub').live('click',function(){
            $(this).parent().remove();
        });
// ******************************************************************
        //添加商品类型 下拉列表绑定属性
        $('select[name=type_id]').on('change',function(){
            
            //获取到当前选中的 商品类型 type_id
            var type_id= $(this).val();
            // alert(type_id);
            //如果 下拉选中的是“请选择” 既 type_id = 0  表示 不需要查询 对应属性信息
            if (type_id=='0') {
                return;
            }
            //发送Ajax 请求 根据type_id
            $.ajax({
                'url':'/index.php/Admin/Goods/getattr',
                'type':'post',
                'data':'type_id='+type_id,
                'dataType:':'json',
                'success':function(responce){
                    console.log(responce);
                    if (responce.code != 10000) {
                        alert(responce.msg);
                    }else{
                        //拿到商品属性 拼接显示到页面的 的html 代码 段
                        var str='';
                        console.log(responce.attr);
                        $.each(responce.attr,function(i,v){
                            str+="<label>"+v.attr_name+"</label>";//属性名
                            if (v.attr_input_type == 0) {
                                //input输入框
                                str+="<input type='text' value='' name='attr_value["+v.attr_id+"][]' />";
                            }

                            if(v.attr_input_type == 1){
                                //下拉列表
                                str+="<select name='attr_value["+v.attr_id+"][]'>";
                                $.each(v.attr_values.split(','),function(index,value){
                                      str += "<option value='"+value+"'>" +value+ "</option>"; 
                                }); 
                                str += "</select>";
                            }
                            if(v.attr_input_type == 2){
                                //多选框
                                $.each(v.attr_values.split(','), function(index, value){
                                    str += "<input type='checkbox' name='attr_value[" + v.attr_id + "][]' value='"+ value +"'>" + value;
                                });
                            }
                           
                        });
                      $('#attr_value').html(str);  
                    }
                }
            });
        });
    });
</script>
</html>