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
						<?php if($_SESSION['user_info']== null ): ?><a href="/index.php/Home/User/login" target="_top" class="h">亲，请登录</a>
						<a href="/index.php/Home/User/register" target="_top">免费注册</a>
						<!-- session中记录用户手机登录  显示手机号加密-->
						<?php elseif($_SESSION['user_info']['phone']!= null ): ?>
						<a href="javascript:void(0);" target="_top" class="h">
						hello,<?php echo (encrypt_phone($_SESSION['user_info']['phone'])); ?></a>
						<a href="/index.php/Home/User/logout" target="_top">退出</a>
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
					<div class="menu-hd"><a href="/index.php/Home/Index/index" target="_top" class="h">商城首页</a></div>
				</div>
				<div class="topMessage my-shangcheng">
					<div class="menu-hd MyShangcheng"><a href="#" target="_top"><i class="am-icon-user am-icon-fw"></i>个人中心</a></div>
				</div>
				<div class="topMessage mini-cart">
					<div class="menu-hd"><a id="mc-menu-hd" href="/index.php/Home/Cart/cart" target="_top"><i class="am-icon-shopping-cart  am-icon-fw"></i><span>购物车</span><strong id="J_MiniCartNum" class="h">0</strong></a></div>
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

		



  <link href="/Public/Home/css/sustyle.css" rel="stylesheet" type="text/css" />
   

  <div class="take-delivery">
   <div class="status">
     <h2>您已成功付款</h2>
     <div class="successInfo">
       <ul>
         <li>付款金额<em>¥<?php echo ($total_fee); ?></em></li>
         <div class="user-info">
           <p>收货人：艾迪</p>
           <p>联系电话：15871145629</p>
           <p>收货地址：湖北省 武汉市 武昌区 东湖路75号众环大厦</p>
         </div>
               请认真核对您的收货信息，如有错误请联系客服
                                 
       </ul>
       <div class="option">
         <span class="info">您可以</span>
          <a href="./person/order.html" class="J_MakePoint">查看<span>已买到的宝贝</span></a>
          <a href="./person/orderinfo.html" class="J_MakePoint">查看<span>交易详情</span></a>
       </div>
      </div>
    </div>
  </div>
 

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