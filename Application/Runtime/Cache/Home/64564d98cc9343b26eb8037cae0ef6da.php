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

		
		<link href="/Public/Home/css/cartstyle.css" rel="stylesheet" type="text/css" />

		<link href="/Public/Home/css/jsstyle.css" rel="stylesheet" type="text/css" />
		<script type="text/javascript" src="/Public/Home/js/address.js"></script>
		<style type="text/css">
			.logistics{
				position: relative;
			}
		</style>
		
		<div class="concent">
			<!--地址 -->
			<div class="paycont">
				<div class="address">
					<h3>确认收货地址 </h3>
					<div class="control">
						<div class="tc-btn createAddr theme-login am-btn am-btn-danger">使用新地址</div>
					</div>
					<div class="clear"></div>
					<ul>
					<?php if(is_array($address)): $key = 0; $__LIST__ = $address;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vol_addr): $mod = ($key % 2 );++$key;?><div class="per-border"></div>
						<!-- 让第一个地址作为默认地址 -->
						<li class="user-addresslist <?php if($key == 1 ): ?>defaultAddr<?php endif; ?>" address_id=<?php echo ($vol_addr["id"]); ?>>

							<div class="address-left">
								<div class="user defaultAddr">

									<span class="buy-address-detail">   
               							<span class="buy-user"><?php echo ($vol_addr["consignee"]); ?> </span>
										<span class="buy-phone"><?php echo ($vol_addr["phone"]); ?></span>
									</span>
								</div>
								<div class="default-address DefaultAddr">
									<span class="buy-line-title buy-line-title-type">收货地址：</span>
									
									<span class="buy--address-detail">
									<?php echo ($vol_addr["address"]); ?>
							   			<!-- span class="province">湖北</span>省
										<span class="city">武汉</span>市
										<span class="dist">洪山</span>区
										<span class="street">雄楚大道666号(中南财经政法大学)</span> -->
									</span>
								</div>
								<ins class="deftip">默认地址</ins>
							</div>
							<div class="address-right">
								<a href="./person/address.html">
									<span class="am-icon-angle-right am-icon-lg"></span></a>
							</div>
							<div class="clear"></div>

							<div class="new-addr-btn">
								<a href="#" class="hidden">设为默认</a>
								<span class="new-addr-bar hidden">|</span>
								<a href="#">编辑</a>
								<span class="new-addr-bar">|</span>
								<a href="javascript:void(0);" onclick="delClick(this);">删除</a>
							</div>
						</li><?php endforeach; endif; else: echo "" ;endif; ?>
					</ul>

					<div class="clear"></div>
				</div>
				<!--物流 -->
				<div class="logistics">
					<h3>选择物流方式</h3>
					<ul class="op_express_delivery_hot">
						<li data-value="yuantong" shipping_type=0 class="OP_LOG_BTN  selected"><i class="c-gap-right" style="background-position:0px -468px"></i>圆通<span></span></li>
						<li data-value="shentong" shipping_type=1 class="OP_LOG_BTN  "><i class="c-gap-right" style="background-position:0px -1008px"></i>申通<span></span></li>
						<li data-value="yunda" shipping_type=2 class="OP_LOG_BTN  "><i class="c-gap-right" style="background-position:0px -576px"></i>韵达<span></span></li>
						<li data-value="zhongtong" shipping_type=3 class="OP_LOG_BTN op_express_delivery_hot_last "><i class="c-gap-right" style="background-position:0px -324px"></i>中通<span></span></li>
						<li data-value="shunfeng" shipping_type=4 class="OP_LOG_BTN  op_express_delivery_hot_bottom"><i class="c-gap-right" style="background-position:0px -180px"></i>顺丰<span></span></li>
					</ul>
				</div>
				<div class="clear"></div>

				<!--支付方式-->
				<div class="logistics">
					<h3>选择支付方式</h3>
					<ul class="pay-list">
						<li class="pay card" pay_type='0' ><img src="/Public/Home/images/wangyin.jpg" />银联<span></span></li>
						<li class="pay qq" pay_type='1' ><img src="/Public/Home/images/weizhifu.jpg" />微信<span></span></li>
						<li class="pay taobao selected" pay_type='2' ><img src="/Public/Home/images/zhifubao.jpg" />支付宝<span></span></li>
					</ul>
				</div>
				<div class="clear"></div>

				<!--订单 -->
				<div class="concent">
					<div id="payTable">
						<h3>确认订单信息</h3>
						<div class="cart-table-th">
							<div class="wp">

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
								<div class="th th-oplist">
									<div class="td-inner">配送方式</div>
								</div>

							</div>
						</div>
						<?php if(is_array($cart)): $k = 0; $__LIST__ = $cart;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vol_data): $mod = ($k % 2 );++$k;?><div class="clear"></div>
							<tr class="item-list">
								<div class="bundle  bundle-last">

									<div class="bundle-main">
										<ul class="item-content clearfix">
											<div class="pay-phone">
												<li class="td td-item">
													<div class="item-pic">
														<a href="/index.php/Home/Index/detail/goods_id/<?php echo ($vol["goods_id"]); ?>" class="J_MakePoint">
															<img src="<?php echo ($vol_data['goods_small_img']); ?>" class="itempic J_ItemImg"></a>
													</div>
													<div class="item-info">
														<div class="item-basic-info">
															<a href="#" class="item-title J_MakePoint" data-point="tbcart.8.11"><?php echo ($vol_data["goods_name"]); ?></a>
														</div>
													</div>
												</li>
												<li class="td td-info">
													<div class="item-props">
													<?php if(is_array($vol_data['goods_attr'])): $i = 0; $__LIST__ = $vol_data['goods_attr'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$goods_attr_vol): $mod = ($i % 2 );++$i;?><span class="sku-line"><?php echo ($goods_attr_vol["attr_name"]); ?>：<?php echo ($goods_attr_vol["attr_value"]); ?>  </span><?php endforeach; endif; else: echo "" ;endif; ?>
													</div>
												</li>
												<li class="td td-price">
													<div class="item-price price-promo-promo">
														<div class="price-content">
															<em class="J_Price price-now"><?php echo ($vol_data["goods_price"]); ?></em>
														</div>
													</div>
												</li>
											</div>
											<li class="td td-amount">
												<div class="amount-wrapper ">
													<div class="item-amount ">
														<span class="phone-title">购买数量</span>
														<div class="sl">
															<input class="min am-btn" name="" type="button" value="-" />
															<input class="text_box" name="" type="text" value="<?php echo ($vol_data["number"]); ?>" style="width:30px;" />
															<input class="add am-btn" name="" type="button" value="+" />
														</div>
													</div>
												</div>
											</li>
											<li class="td td-sum">
												<div class="td-inner">
													<em tabindex="0" class="J_ItemSum number"><?php echo ($vol_data['number'] * $vol_data['goods_price']); ?></em>
												</div>
											</li>
											<li class="td td-oplist">
												<div class="td-inner">
													<span class="phone-title">配送方式</span>
													<div class="pay-logis">
														<!-- 快递<b class="sys_item_freprice">10</b>元 -->
														免邮费！
													</div>
												</div>
											</li>
										</ul>
										<div class="clear"></div>

									</div>
								</div>
							</tr><?php endforeach; endif; else: echo "" ;endif; ?>
					</div>
					<div class="clear"></div>
					<div class="pay-total">
						<!--留言-->
						<div class="order-extra">
							<div class="order-user-info">
								<div id="holyshit257" class="memo">
									<label>买家留言：</label>
									<input type="text" title="选填,对本次交易的说明（建议填写已经和卖家达成一致的说明）" placeholder="选填,建议填写和卖家达成一致的说明" class="memo-input J_MakePoint c2c-text-default memo-close">
									<div class="msg hidden J-msg">
										<p class="error">最多输入500个字符</p>
									</div>
								</div>
							</div>

						</div>
						<!--优惠券 -->
						<div class="buy-agio">
							<li class="td td-coupon">

								<span class="coupon-title">优惠券</span>
								<select data-am-selected>
									<option value="a">
										<div class="c-price">
											<strong>￥8</strong>
										</div>
										<div class="c-limit">
											【消费满95元可用】
										</div>
									</option>
									<option value="b" selected>
										<div class="c-price">
											<strong>￥3</strong>
										</div>
										<div class="c-limit">
											【无使用门槛】
										</div>
									</option>
								</select>
							</li>

							<li class="td td-bonus">

								<span class="bonus-title">红包</span>
								<select data-am-selected>
									<option value="a">
										<div class="item-info">
											¥50.00<span>元</span>
										</div>
										<div class="item-remainderprice">
											<span>还剩</span>10.40<span>元</span>
										</div>
									</option>
									<option value="b" selected>
										<div class="item-info">
											¥50.00<span>元</span>
										</div>
										<div class="item-remainderprice">
											<span>还剩</span>50.00<span>元</span>
										</div>
									</option>
								</select>

							</li>

						</div>
						<div class="clear"></div>
					</div>
					<!--含运费小计 -->
					<div class="buy-point-discharge ">
						<p class="price g_price ">
							合计（含运费） <span>¥</span><em class="pay-sum">
							<?php echo ($total_price); ?>元</em>
						</p>
					</div>

					<!--信息 -->
					<div class="order-go clearfix">
						<div class="pay-confirm clearfix">
							<div class="box">
								<div tabindex="0" id="holyshit267" class="realPay"><em class="t">实付款：</em>
									<span class="price g_price ">
                            			<span>¥</span> <em class="style-large-bold-red " id="J_ActualFee"><?php echo ($total_price); ?>元</em>
									</span>
								</div>

								<div id="holyshit268" class="pay-address">

									<p class="buy-footer-address">
										<span class="buy-line-title buy-line-title-type">寄送至：</span>
										<span class="buy--address-detail">
										<?php echo ($vol_addr["address"]); ?>
						   					<!-- <span class="province">湖北</span>省
											<span class="city">武汉</span>市
											<span class="dist">洪山</span>区
											<span class="street">雄楚大道666号(中南财经政法大学)</span> -->

										</span>
									</p>
									<p class="buy-footer-address">
										<span class="buy-line-title">收货人：</span>
										<span class="buy-address-detail">   
                                 			<span class="buy-user"><?php echo ($vol_addr["consignee"]); ?> </span>
											<span class="buy-phone"><?php echo ($vol_addr["phone"]); ?></span>
										</span>
									</p>
								</div>
							</div>

							<div id="holyshit269" class="submitOrder">
								<div class="go-btn-wrap">
									<a id="J_Go" href="javascript:void(0);" class="btn-go" tabindex="0" title="点击此按钮，提交订单">提交订单</a>
								</div>
							</div>
							<div class="clear"></div>
						</div>
					</div>

					<div class="clear"></div>
				</div>
			</div>
		</div>
		<div class="theme-popover-mask"></div>
		<div class="theme-popover">

			<!--标题 -->
			<div class="am-cf am-padding">
				<div class="am-fl am-cf"><strong class="am-text-danger am-text-lg">新增地址</strong> / <small>Add address</small></div>
			</div>
			<hr/>

			<div class="am-u-md-12">
				<form class="am-form am-form-horizontal">

					<div class="am-form-group">
						<label for="user-name" class="am-form-label">收货人</label>
						<div class="am-form-content">
							<input type="text" id="user-name" placeholder="收货人">
						</div>
					</div>

					<div class="am-form-group">
						<label for="user-phone" class="am-form-label">手机号码</label>
						<div class="am-form-content">
							<input id="user-phone" placeholder="手机号必填" type="email">
						</div>
					</div>

					<div class="am-form-group">
						<label for="user-phone" class="am-form-label">所在地</label>
						<div class="am-form-content address">
							<select data-am-selected>
								<option value="a">浙江省</option>
								<option value="b">湖北省</option>
							</select>
							<select data-am-selected>
								<option value="a">温州市</option>
								<option value="b">武汉市</option>
							</select>
							<select data-am-selected>
								<option value="a">瑞安区</option>
								<option value="b">洪山区</option>
							</select>
						</div>
					</div>

					<div class="am-form-group">
						<label for="user-intro" class="am-form-label">详细地址</label>
						<div class="am-form-content">
							<textarea class="" rows="3" id="user-intro" placeholder="输入详细地址"></textarea>
							<small>100字以内写出你的详细地址...</small>
						</div>
					</div>

					<div class="am-form-group theme-poptit">
						<div class="am-u-sm-9 am-u-sm-push-3">
							<div class="am-btn am-btn-danger">保存</div>
							<div class="am-btn am-btn-danger close">取消</div>
						</div>
					</div>
				</form>
			</div>
		</div>
	<!-- 隐藏表单 用来存放 生成订单数据 -->
	<form action="/index.php/Home/Cart/createorder" id="order_form" method="post" style="display:none">
		<input type="text" class="address_id" name="address_id" value=""></input>
		<input type="text" class="shipping_type" name="shipping_type" value=""></input>
		<input type="text" class="pay_type" name="pay_type" value=""></input>
		<input type="text" class="cart_ids" name="cart_ids" value="<?php echo ($_GET['cart_ids']); ?>"></input>
	</form>
<script type="text/javascript">
	//给提交订单 a 标签 绑定一个onclick 事件
	$(function(){
		$('#J_Go').click(function(){
			
			// alert(1);
			//收集表单缺少的数据
			var address_id = $('.user-addresslist.defaultAddr').attr('address_id');
			var shipping_type = $('.OP_LOG_BTN.selected').attr('shipping_type');
			var pay_type = $('.pay.selected').attr('pay_type');
			//把数据放入隐藏表单里
			$('.address_id').val(address_id);
			$('.shipping_type').val(shipping_type);
			$('.pay_type').val(pay_type);
			//提交表单
			$('#order_form').submit();
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