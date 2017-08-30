<?php 
namespace Home\Controller;
use Think\Controller;
class CartController extends Controller{
	//加入购物车的方法
	public function addcart(){
		$title="添加购物车";
        $this->assign('title',$title);
		if (IS_POST) {
			$data= I('post.');
		 	 // dump($data);die;
			//把购物记录 加入购物车数据中
			$res=D('Cart')->addCart($data['goods_id'],$data['number'],$data['goods_attr_ids']);
			if ($res) {
				//加入成功之前查询商品基本信息（logo图片 名称等）
				$goods=M('Goods')->find($data['goods_id']);
				$this->assign('goods',$goods);
				//加入成功显示成页面
				$this->display();
			} else {
				// 加入失败
				$this->error('添加失败！');
			}
			
		} else {
			$this->redirect('Home/Index/index');
		}
	} 

	//购物车列表页
	public function cart(){
		$title="购物车页面";
        $this->assign('title',$title);
		//调用模型方法 获取数据
		$data = D('Cart') -> getAllCart();
		//使用foreach 遍历 需要修改 $v的值需要加& 符号
		foreach ($data as $k => &$v) {
			$goods=M('Goods')->find($v['goods_id']);
			$v['goods_name']=$goods['goods_name'];
			$v['goods_small_img']=$goods['goods_small_img'];
			$v['goods_price']=$goods['goods_price'];

			//查询商品属性及属性值 goods_attr表 和 tpshop_attribute 连表查询 
			$attr= M('GoodsAttr')->alias('t1')->field('t1.*,t2.attr_name')->join('left join tpshop_attribute t2 on t1.attr_id = t2.attr_id')->where("t1.id in ({$v['goods_attr_ids']})")->select();
			$v['attr'] = $attr;
		}
		// $number=D('Cart')->sum('number');
		// $this->assign('number',$number);
		$this->assign('data',$data);
		$this->display();
	}

	//ajax 获取购物车商品 购买的总数量的方法
	public function ajaxgetnum(){
		//调用cart 模型中的getNumber 方法 获取数量
		$total_number = D('Cart')->getNumber();
		//返回数据
		$return=array(
			'code'=>10000,
			'msg'=>'success',
			'total_number'=>$total_number
			);
		$this->ajaxReturn($return);
	}

	//ajax 请求修改 购买数量
	public function ajaxchangenum(){
		//获取ajax 传递数据
		$data = I('post.');
		
		$model=D('Cart');
		$res=$model->changeNumber($data['goods_id'],$data['goods_attr_ids'],$data['number']);
		if ($res) {
			//获取一次购物车 商品总数量
			$total_number=$model->getNumber();
			$return=array(
				'code' 	=>10000,
				'msg'	=>'success',
				'total_number' 	=>$total_number
				);
			$this->ajaxReturn($return);
		} else {
			$return=array(
				'code' 	=>10001,
				'msg'	=>'修改失败'
				);
			$this->ajaxReturn($return);
		}
	}

	//ajax 请求删除购物车 数据方法
	public function ajaxdelcart(){
		$data=I('post.');
		$model=D('Cart');
		$res=$model->delcart($data['goods_id'],$data['goods_attr_ids']);
		$total_number=$model->getNumber();
		if ($res !== flase) {
			//删除成功
			$return=array(
   				'code'=>10000,
   				'msg'=>'success',
   				'total_number'=>$total_number
				);
			$this->ajaxReturn($return);
		} else {
			//删除失败
			$return=array(
   				'code'=>10001,
   				'msg'=>'删除失败',
				);
			$this->ajaxReturn($return);
		}	
	}	

	//结算页面
	public function flow2(){
		$title="订单信息确认页";
        $this->assign('title',$title);
		if (!session('?user_info')) {
			//没有登录 跳转到登录页面 登录成功后 跳转到购物车列表页
			session('back_url',U('Home/Cart/cart'));
			$this->redirect('Home/User/login');
		}
		//已登录 查询 收获地址信息
		$user_id = session('user_info.id');
		// dump($user_id);
		$address = M('Address')->where(array('user_id'=>$user_id))->select();
		// dump($address);die;
		$this->assign('address',$address);

		//获取点击结算 提交过来的参数
		$cart_ids=I('get.cart_ids'); 
		 // dump($cart_ids);die;
		 // 连表查询
		 $cart = D('Cart')->alias('t1')->field('t1.*,t2.goods_name,t2.goods_small_img,t2.goods_price')->join('left join tpshop_goods t2 on t1.goods_id=t2.id')->where("t1.id in ($cart_ids)")->select();
		 // dump($cart);
		 //连表查新商品属性信息
		 $total_price="";
		 foreach ($cart as $k => &$v) {
		 	$v['goods_attr'] = M('GoodsAttr')->alias('t3')->field('t3.*,t4.attr_name')->join("left join tpshop_attribute t4 on t3.attr_id=t4.attr_id ")->where("t3.id in ({$v['goods_attr_ids']})")->select();

		 	//计算总金额
		 	$total_price += $v['number'] * $v['goods_price'];
		 }

		 $this->assign('total_price',$total_price);
		 $this->assign('cart',$cart);
		  // dump($cart);
		//展示模板
		$this->display();
	}

	//创建订单方法
	public function createorder(){
		if (IS_POST) {
			//获取表单提交值
			$data = I('post.');
			// dump($data);
			// 生成 订单记录保存进 订单表
			// 当前时间时间戳加10000到99999之间的随机数
			$data['order_sn'] = date(YmdHis).rand(10000,99999);
			$data['user_id'] = session('user_info.id');
			$data['create_time'] = time();
			//订单总金额 连表查询 查询 购物车里的 商品数量 和 goods表中商品单价 goods_id = id
			$goods_data = M('Cart')->alias('t1')->field('t1.*,t2.goods_price')->join('left join tpshop_goods t2 on t1.goods_id=t2.id')->where("t1.id in ({$data['cart_ids']})")->select();
			// 遍历循环$goods_data 获取订单中商品数目和单价 每一条
			foreach ($goods_data as $k => $v) {
				$data['order_amount'] += $v['number'] * $v['goods_price'];
			}
			unset($k,$v);//若$v 使用了引用 &$v 的话 后边还要使用 需要销毁变量
			//将订单数据 保存入数据表中 返回 添加数据的主键值（id）
 			$order_id = M('Order')->add($data);
 			//将数据保存 入 商品订单关联表中
 			if ($order_id) {
 				//遍历数组 获取 商品订单 表中所需 字段 及值
 				foreach ($goods_data as $k => $v) {
 					$row['order_id']=$order_id;
 					$row['goods_id']=$v['goods_id'];
 					$row['goods_price']=$v['goods_price'];
 					$row['number']=$v['number'];
 					$row['goods_attr_ids']=$v['goods_attr_ids'];
 					//将$row 保存进 order_goods 表中
 					// dump($row);die;
 					M('OrderGoods')->add($row);
 				}
 				//接下来就是跳转到第三方支付平台
 				$html = "<form action='/Application/Tools/alipay/alipayapi.php' id='alpayform' class='alipayform' method='post' >
							<input type='text' name='WIDout_trade_no' id='out_trade_no' value='{$data['order_sn']}'>
							<input type='text' name='WIDsubject' value='测试商品名称'>
							<input type='text' name='WIDtotal_fee' value='{$data['order_amount']}'>
							<input type='text' name='WIDbody' value='即时到账测试'>
						</form><script>document.getElementById('alpayform').submit();</script>";
				echo $html;
 			}else{
 				$this->error('提交订单失败');
 			}
		} 
	}

	//支付成功页面显示
	public function flow3(){
		$title="支付成功页面";
        $this->assign('title',$title);
		// 这里提供给第三方网站跳转，会携带一些get参数 比如说订单号 支付金额
		// 接收第三方支付传递回来的参数 展示到 页面中
		$data=I('get.total_fee');

		$this->assign('data',$data);
		$this->display();
	}

	//支付宝异步通知信息
	public function alipaynotify(){
		$data = I('post.');
		//修改 订单状态等信息
		//处理完成需要通知支付宝 否则支付宝会一直调用此接口
		return true;
		
	}
}