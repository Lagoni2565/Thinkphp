<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">

		<title><?php echo ((isset($title ) && ($title !== ""))?($title ):"首页"); ?></title>

		<link href="/Public/Home/css/amazeui.css" rel="stylesheet" type="text/css" />
		<link href="/Public/Home/css/admin.css" rel="stylesheet" type="text/css" />
		<link href="/Public/Home/css/demo.css" rel="stylesheet" type="text/css" />
		<link href="/Public/Home/css/hmstyle.css" rel="stylesheet" type="text/css" />
		<style type="text/css">
			.nav-cont .nav-extra{background: url(/Public/Home/images/extra.png);}
		</style>

		<script src="/Public/Home/js/jquery.min.js"></script>
		<script src="/Public/Home/js/amazeui.min.js"></script>
		<script src="/Public/Home/js/quick_links.js"></script>
	</head>
	<body>
	<!--头-->		
		<!--顶部导航条 -->
		<div class="am-container header">
			<ul class="message-l">
				<div class="topMessage">
					<div class="menu-hd">
						<!-- 若session 为空说明为登录 -->
						<?php if($_SESSION['user_info']== null ): ?><a href="/login.html" target="_top" class="h">亲，请登录</a>
						<a href="/register.html" target="_top">免费注册</a>
						<!-- session中记录用户手机登录  显示手机号加密-->
						<?php elseif($_SESSION['user_info']['phone']!= null ): ?>
						<a href="javascript:void(0);" target="_top" class="h">
						hello,<?php echo (encrypt_phone($_SESSION['user_info']['phone'])); ?></a>
						<a href="/logout.html" target="_top">退出</a>
						<!-- 若用户不是有手机号登录 使用邮箱登录 -->
						<?php elseif($_SESSION['user_info']['email']!= null ): ?>

						<a href="javascript:void(0);" target="_top" class="h">
						hello,<?php echo ($_SESSION['user_info']['email']); ?></a>
						<a href="/index.php/Home/User/logout" target="_top">退出</a>
						<!-- 其他登录为用户名登录 -->
						<?php else: ?>
						<a href="javascript:void(0);" target="_top" class="h">
						hello,<?php echo ($_SESSION['user_info']['username']); ?></a>
						<a href="/index.php/Home/User/logout" target="_top">退出</a><?php endif; ?>
					</div>
				</div>
			</ul>
			<ul class="message-r">
				<div class="topMessage home">
					<div class="menu-hd"><a href="/index.html" target="_top" class="h">商城首页</a></div>
				</div>
				<div class="topMessage my-shangcheng">
					<div class="menu-hd MyShangcheng"><a href="#" target="_top"><i class="am-icon-user am-icon-fw"></i>个人中心</a></div>
				</div>
				<div class="topMessage mini-cart">
					<div class="menu-hd"><a id="mc-menu-hd" href="/cart.html" target="_top"><i class="am-icon-shopping-cart  am-icon-fw"></i><span>购物车</span><strong id="J_MiniCartNum" class="h">0</strong></a></div>
				</div>
				<div class="topMessage favorite">
					<div class="menu-hd"><a href="#" target="_top"><i class="am-icon-heart am-icon-fw"></i><span>收藏夹</span></a></div>
				</div>
			</ul>
		</div>
		<!--悬浮搜索框-->
		<div class="nav white">
			<div class="logo"><img src="/Public/Home/images/logo.png" /></div>
			<div class="logoBig">
				<li><img src="/Public/Home/images/logobig.png" /></li>
			</div>

			<div class="search-bar pr">
				<a name="index_none_header_sysc" href="#"></a>
				<form>
					<input id="searchInput" name="index_none_header_sysc" type="text" placeholder="搜索" autocomplete="off">
					<input id="ai-topsearch" class="submit am-btn" value="搜索" index="1" type="submit">
				</form>
			</div>
		</div>
		<!-- 清除浮动 -->
		<div class="clear"></div>
		<!-- 以上为头部内容 -->
		<!-- 一下特殊字符串 代表原始要访问额页面内容 -->

				<link href="/Public/Home/css/cartstyle.css" rel="stylesheet" type="text/css" />
		<link href="/Public/Home/css/optstyle.css" rel="stylesheet" type="text/css" />
		
		<!--购物车 -->
		<div class="concent">
			<div id="cartTable">
				<div class="cart-table-th">
					<div class="wp">
						<div class="th th-chk">
							<div id="J_SelectAll1" class="select-all J_SelectAll">

							</div>
						</div>
						<div class="th th-item">
							<div class="td-inner">商品信息</div>
						</div>
						<div class="th th-price">
							<div class="td-inner">单价</div>
						</div>
						<div class="th th-amount">
							<div class="td-inner">数量</div>
						</div>
						<div class="th th-sum">
							<div class="td-inner">金额</div>
						</div>
						<div class="th th-op">
							<div class="td-inner">操作</div>
						</div>
					</div>
				</div>
				<div class="clear"></div>

				<tr class="item-list">
					<div class="bundle  bundle-last ">
						<div class="bundle-hd">
							<div class="bd-promos">
								<div class="bd-has-promo">已享优惠:<span class="bd-has-promo-content">省￥19.50</span>&nbsp;&nbsp;</div>
								<div class="act-promo">
									<a href="#" target="_blank">第二支半价，第三支免费<span class="gt">&gt;&gt;</span></a>
								</div>
								<span class="list-change theme-login">编辑</span>
							</div>
						</div>
						<div class="clear"></div>
						<div class="bundle-main">
						<?php if(is_array($data)): $i = 0; $__LIST__ = $data;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vol): $mod = ($i % 2 );++$i;?><!-- 将待传递参数放入属性中 -->
							<ul class="item-content clearfix" goods_id="<?php echo ($vol["goods_id"]); ?>" goods_attr_ids="<?php echo ($vol["goods_attr_ids"]); ?>" cart_id="<?php echo ((isset($vol["id"]) && ($vol["id"] !== ""))?($vol["id"]):0); ?>" >
								<li class="td td-chk">
									<div class="cart-checkbox ">
										<input class="check row_check" name="items[]" value="170037950254" type="checkbox">
										<label for="J_CheckBox_170037950254"></label>
									</div>
								</li>
								<li class="td td-item">
									<div class="item-pic">
										<a href="#" target="_blank" data-title="美康粉黛醉美东方唇膏口红正品 持久保湿滋润防水不掉色护唇彩妆" class="J_MakePoint" data-point="tbcart.8.12">
											<img src="<?php echo ($vol["goods_small_img"]); ?>" class="itempic J_ItemImg"></a>
									</div>
									<div class="item-info">
										<div class="item-basic-info">
											<a href="#" target="_blank" title="<?php echo ($vol["goods_name"]); ?>" class="item-title J_MakePoint" data-point="tbcart.8.11"><?php echo ($vol["goods_name"]); ?></a>
										</div>
									</div>
								</li>
								<li class="td td-info">
									<div class="item-props item-props-can">
										<?php if(is_array($vol["attr"])): $i = 0; $__LIST__ = $vol["attr"];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vol_attr): $mod = ($i % 2 );++$i;?><span class="sku-line"><?php echo ($vol_attr["attr_name"]); ?>：<?php echo ($vol_attr["attr_value"]); ?><br> </span><?php endforeach; endif; else: echo "" ;endif; ?>
										<span tabindex="0" class="btn-edit-sku theme-login">修改</span>
										<i class="theme-login am-icon-sort-desc"></i>
									</div>
								</li>
								<li class="td td-price">
									<div class="item-price price-promo-promo">
										<div class="price-content">
											<div class="price-line">
												<em class="price-original"><?php echo ($vol["goods_price"]); ?></em>
											</div>
											<div class="price-line">
												<em class="J_Price price-now" tabindex="0"><?php echo ($vol["goods_price"]); ?></em>
											</div>
										</div>
									</div>
								</li>
								<li class="td td-amount">
									<div class="amount-wrapper ">
										<div class="item-amount ">
											<div class="sl">
												<input class="min am-btn sub_number" name="" type="button" value="-" />
												<input class="text_box current_number" name="" type="text" value="<?php echo ($vol["number"]); ?>" style="width:30px;" />
												<input class="add am-btn add_number" name="" type="button" value="+" />
											</div>
										</div>
									</div>
								</li>
								<li class="td td-sum">
									<div class="td-inner">
										<em tabindex="0" class="J_ItemSum number row_price">
											<?php echo ($vol['goods_price'] * $vol['number']); ?>
										</em>
									</div>
								</li>
								<li class="td td-op">
									<div class="td-inner">
										<a title="移入收藏夹" class="btn-fav" href="#"> 移入收藏夹</a>
										<a href="javascript:;" data-point-url="#" class="delete"> 删除</a>
									</div>
								</li>
							</ul><?php endforeach; endif; else: echo "" ;endif; ?>
						</div>
					</div>
				</tr>
				<div class="clear"></div>
			</div>
			<div class="clear"></div>

			<div class="float-bar-wrapper">
				<div id="J_SelectAll2" class="select-all J_SelectAll">
					<div class="cart-checkbox">
						<input class="check-all check" name="select-all" value="true" type="checkbox">
						<label for="J_SelectAllCbx2"></label>
					</div>
					<span>全选</span>
				</div>
				<div class="operations">
					<a href="#" hidefocus="true" class="deleteAll">删除</a>
					<a href="#" hidefocus="true" class="J_BatchFav">移入收藏夹</a>
				</div>
				<div class="float-bar-right">
					<div class="amount-sum">
						<span class="txt">已选商品</span>
						<em id="J_SelectedItemsCount"></em><span class="txt">件</span>
						<div class="arrow-box">
							<span class="selected-items-arrow"></span>
							<span class="arrow"></span>
						</div>
					</div>
					<div class="price-sum">
						<span class="txt">合计:</span>
						<strong class="price">¥<em id="J_Total">0.00</em></strong>
					</div>
					<div class="btn-area">
						<a href="javascript:void(0);" id="J_Go" class="submit-btn submit-btn-disabled" aria-label="请注意如果没有选择宝贝，将无法结算">
							<span>结&nbsp;算</span></a>
					</div>
				</div>

			</div>
		</div>
<script type="text/javascript">
	$(function(){
		//封装修改购买数量的方法
		var changenum = function(new_number,element){
			//分析 ajax 请求 所需的数据  goods_id goods_attr_ids number
			var goods_id= $(element).closest('ul').attr('goods_id');
			var goods_attr_ids = $(element).closest('ul').attr('goods_attr_ids');
			//构建请求数据
			var data={
				'goods_id':goods_id,
				'goods_attr_ids':goods_attr_ids,
				'number':new_number
			}
			// console.log(data);
			//发送Ajax请求
			// var _this=element;
			$.ajax({
				'url':'/index.php/Home/Cart/ajaxchangenum',
				'type':'post',
				'data':data,
				'dataType':'json',
				'success':function(response){
					console.log(response);
					if (response.code != 10000) {
						alert(response.msg);
						return;
					}else{
						//先修改当前行
						$(element).closest('ul').find('.current_number').val(new_number);
						//修改当前行的总金额
						var now_price= parseFloat($(element).closest('ul').find('.price-now').text());
						var row_price = now_price * new_number;
						$(element).closest('ul').find('.row_price').text(row_price);

						//修改头部的购物车的数量
						$('#J_MiniCartNum').text(response.total_number);
						//调用changetotal(); 方法重新计算 已选商品总价格 总数量
						changetotal();
					}
				}
			});
		}
		
		//封装一个 计算 已选商品数量和总金额的函数
		var changetotal=function(){
			//获取所有选中的checkbox 
			var checked_checkbox=$('.row_check:checked');
			var total_number=0;
			var total_price=0;
			$.each(checked_checkbox,function(i,v){
				//获取总件数
				var current_number= parseInt($(v).closest('ul').find('.current_number').val());
				total_number += current_number;
				//获取总价格
				var now_price=parseFloat($(v).closest('ul').find('.price-now').text());
				total_price+=now_price * current_number;
			});
			//将总件数和 总价 显示在页面上
			$('#J_SelectedItemsCount').text(total_number);
			$('#J_Total').text(total_price);
		};
		//点击+ 号 增加商品数量 修改购物车总数
		$('.add_number').click(function(){
			var current_number=parseInt($(this).closest('ul').find('.current_number').val());
			var new_number= current_number + 1;
			
			//一次最大购买量 1000
			if (new_number > 1000) {
				new_number = 1000;
			}
			//调用changenum 发送请求
		    changenum(new_number,this);
		});
		$('.sub_number').click(function(){
			var current_number=parseInt($(this).closest('ul').find('.current_number').val());
			var new_number= current_number - 1;
			//设定下限
			if (new_number<1) {
				new_number=1;
			}
			changenum(new_number,this);
		});
		$('.current_number').change(function(){
			var current_number = parseInt($(this).val());
			var new_number = current_number;
			// 设定界限
			if (new_number<1) {
				new_number=1;
			}
			if (new_number > 1000) {
				new_number = 1000;
			}
			changenum(new_number,this);
		});

		//删除 cart 表中数据 删除
		//给a标签 绑定点击事件 点击 发送 ajax 请求 删除本行数据
		$('.delete').click(function(){
			var goods_id=$(this).closest('ul').attr('goods_id');
			var goods_attr_ids=$(this).closest('ul').attr('goods_attr_ids');
			var data={
				'goods_id':goods_id,
				'goods_attr_ids':goods_attr_ids,
				};
				
			var _this=this;
			$.ajax({
				'url':'/index.php/Home/Cart/ajaxdelcart',
				'type':'post',
				'data':data,
				'dataType':'json',
				'success':function(response){
					console.log(response);
					if (response.code !=10000) {
						alert(response.msg);
						return;
					}else{
						//移除当前行 $().remove();
						$(_this).closest('ul').remove();
						//修改购物车 数量显示
						$('#J_MiniCartNum').text(response.total_number);
						//调用changetotal(); 方法重新计算 已选商品总价格 总数量
						changetotal();
					}
				}
			});
		});

		//给checkbox 绑定 change 事件 
		$('.row_check').change(function(){
			//调用changetotal(); 方法重新计算 已选商品总价格 总数量
			changetotal();
			//获取所有的checkbox  的行数 在获取 已选择的行数
			var checkbox_all = $('.row_check').length;
			var checkbox_checked = $('.row_check:checked').length;
			if (checkbox_all == checkbox_checked) {
				//相等 所有checkbox 都选中了 需要让全选 选中
				$('.check-all').prop('checked',true);
			}else{
				//不相等 有checkbox 没被选中了 需要让全选 
				$('.check-all').prop('checked',false);
			}
		});

		//给全选 checkbox 绑定change事件
		$('.check-all').change(function(){
			//获取当前 全选 checkbox 状态
			//使用prop('选择器'); 获取固有属性的值
			//同步全选的状态到 每一行的checkbox
			$('.row_check').prop('checked',$(this).prop('checked'));

			//调用changetotal(); 方法重新计算 已选商品总价格 总数量
			changetotal();

		});

		//给结算按钮绑定 单击事件 传递cart_ids 到结算页 
		$('#J_Go').click(function(){ 
		
			// 通过checkbox 获取所有选中的行 
			var checked_checkbox=$('.row_check:checked');
			if (checked_checkbox.length == 0) {
				alert('请先选中要结算的商品');
				return false;
			}
			//通过遍历获取 ul 标签里的属性值 cart_id
			// 把所有的 cart_id 拼接成‘1,2’ 作为一个参数放到 url上
			var cart_ids="";
			$.each(checked_checkbox,function(i,v){
				var cart_id=$(v).closest('ul').attr('cart_id');
				cart_ids+=cart_id+',';
			});
			//去出最后一个逗号
			cart_ids= cart_ids.slice(0,-1);
			var url="/index.php/Home/Cart/flow2/cart_ids/"+cart_ids;
			location.href=url;
		});
	});
</script>
		

		<!-- 以下是尾部内容 -->
		<!-- 清除浮动 -->
		<div class="clear "></div>
		
		<!-- 底部内容 -->
		<div class="footer ">
			<div class="footer-hd ">
				<p>
					<a href="# ">恒望科技</a>
					<b>|</b>
					<a href="# ">商城首页</a>
					<b>|</b>
					<a href="# ">支付宝</a>
					<b>|</b>
					<a href="# ">物流</a>
				</p>
			</div>
			<div class="footer-bd ">
				<p>
					<a href="# ">关于恒望</a>
					<a href="# ">合作伙伴</a>
					<a href="# ">联系我们</a>
					<a href="# ">网站地图</a>
				</p>
			</div>
		</div>
		<!--右侧菜单 -->
		<div class=tip>
			<div id="sidebar">
				<div id="wrap">
					<div id="prof" class="item ">
						<a href="# ">
							<span class="setting "></span>
						</a>
						<div class="ibar_login_box status_login ">
							<div class="avatar_box ">
								<p class="avatar_imgbox "><img src="/Public/Home/images/no-img_mid_.jpg " /></p>
								<ul class="user_info ">
									<li><?php echo ($_SESSION['user_info']['username']); ?></li>
									<li>级&nbsp;别：
									<?php if($_SESSION['user_info']['leavel']< 5 ): ?>普通会员<?php endif; ?>
									<?php if(($_SESSION['user_info']['leavel']> 5) and ($_SESSION['user_info']['leavel']< 16) ): ?>黄金会员<?php endif; ?>
									</li>
								</ul>
							</div> 
							<div class="login_btnbox ">
								<a href="# " class="login_order ">我的订单</a>
								<a href="# " class="login_favorite ">我的收藏</a>
							</div>
							<i class="icon_arrow_white "></i>
						</div>

					</div>
					<div id="shopCart " class="item ">
						<a href="/index.php/Home/Cart/cart ">
							<span class="message "></span>
						</a>
						<p>
							购物车
						</p>
						<p class="cart_num" >0</p>
					</div>
					<div id="asset " class="item ">
						<a href="# ">
							<span class="view "></span>
						</a>
						<div class="mp_tooltip ">
							我的资产
							<i class="icon_arrow_right_black "></i>
						</div>
					</div>

					<div id="foot " class="item ">
						<a href="# ">
							<span class="zuji "></span>
						</a>
						<div class="mp_tooltip ">
							我的足迹
							<i class="icon_arrow_right_black "></i>
						</div>
					</div>

					<div id="brand " class="item ">
						<a href="#">
							<span class="wdsc "><img src="/Public/Home/images/wdsc.png " /></span>
						</a>
						<div class="mp_tooltip ">
							我的收藏
							<i class="icon_arrow_right_black "></i>
						</div>
					</div>

					<div id="broadcast " class="item ">
						<a href="# ">
							<span class="chongzhi "><img src="/Public/Home/images/chongzhi.png " /></span>
						</a>
						<div class="mp_tooltip ">
							我要充值
							<i class="icon_arrow_right_black "></i>
						</div>
					</div>

					<div class="quick_toggle ">
						<li class="qtitem ">
							<a href="# "><span class="kfzx "></span></a>
							<div class="mp_tooltip ">客服中心<i class="icon_arrow_right_black "></i></div>
						</li>
						<!--二维码 -->
						<li class="qtitem ">
							<a href="#none "><span class="mpbtn_qrcode "></span></a>
							<div class="mp_qrcode " style="display:none; "><img src="/Public/Home/images/weixin_code_145.png " /><i class="icon_arrow_white "></i></div>
						</li>
						<li class="qtitem ">
							<a href="#top " class="return_top "><span class="top "></span></a>
						</li>
					</div>

					<!--回到顶部 -->
					<div id="quick_links_pop " class="quick_links_pop hide "></div>

				</div>

			</div>
			<div id="prof-content " class="nav-content ">
				<div class="nav-con-close ">
					<i class="am-icon-angle-right am-icon-fw "></i>
				</div>
				<div>
					我
				</div>
			</div>
			<div id="shopCart-content " class="nav-content ">
				<div class="nav-con-close ">
					<i class="am-icon-angle-right am-icon-fw "></i>
				</div>
				<div>
					购物车
				</div>
			</div>
			<div id="asset-content " class="nav-content ">
				<div class="nav-con-close ">
					<i class="am-icon-angle-right am-icon-fw "></i>
				</div>
				<div>
					资产
				</div>

				<div class="ia-head-list ">
					<a href="# " target="_blank " class="pl ">
						<div class="num ">0</div>
						<div class="text ">优惠券</div>
					</a>
					<a href="# " target="_blank " class="pl ">
						<div class="num ">0</div>
						<div class="text ">红包</div>
					</a>
					<a href="# " target="_blank " class="pl money ">
						<div class="num ">￥0</div>
						<div class="text ">余额</div>
					</a>
				</div>

			</div>
			<div id="foot-content " class="nav-content ">
				<div class="nav-con-close ">
					<i class="am-icon-angle-right am-icon-fw "></i>
				</div>
				<div>
					足迹
				</div>
			</div>
			<div id="brand-content " class="nav-content ">
				<div class="nav-con-close ">
					<i class="am-icon-angle-right am-icon-fw "></i>
				</div>
				<div>
					收藏
				</div>
			</div>
			<div id="broadcast-content " class="nav-content ">
				<div class="nav-con-close ">
					<i class="am-icon-angle-right am-icon-fw "></i>
				</div>
				<div>
					充值
				</div>
			</div>
		</div>
	</body>

</html>
<!-- 页面头部 购物车数量显示 -->
<script type="text/javascript">
	$(function(){
		$.ajax({
			'url':'/index.php/Home/Cart/ajaxgetnum',
			'type':'post',
			'data':'',
			'dataType':'json',
			'success':function(response){
				console.log(response);
				if (response.code != 10000) {
					alert(response.msg);
					return;
				}else{
					$('#J_MiniCartNum').text(response.total_number);
					$('.cart_num').text(response.total_number);
				}
			}
		});
	})
</script>