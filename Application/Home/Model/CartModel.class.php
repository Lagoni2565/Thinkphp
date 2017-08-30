<?php
namespace Home\Model;
use Think\Model;
class CartModel extends Model{
	//创建添加购物车 addCart方法 
    public function addCart($goods_id,$number,$goods_attr_ids){
    
        //判断登录状态 决定是把数据保存在cookie中还是 数据库中
        if(session('?user_info')){
            //已经登录 将数据保存在数据库中
            //获取到存在session 中的商品 user_id
            $user_id=session('user_info.id');
            //构建查询条件数组
            $data= array(
            	'user_id'		=>$user_id,
            	'goods_id'		=>$goods_id,
            	'goods_attr_ids'	=>$goods_attr_ids,
            	);
            //保存数据库时 要先查询数据表中是否已存在 该商品 若存在则修改购买数量
            $cart=$this->where($data)->find();
            if ($cart) {//购物车中已存在该商品
            	$cart['number']+=$number;//修改商品数量
            	$this->save($cart);//保存入数据库
            	return $res !== false ? true :false;
            } else {
            	//不存在 相关记录 则添加数据到数据库
            	$data['number']=$number;//将商品数量添加到数据库中
            	$res=$this->add($data);
            	return $res ? true :false;
            }
        }else{
        	//未登录则将商品信息数据 保存在cookie中
        	//判断cookie 存在与否(cookie中保存的是序列化的数组)
        	$cart_data = cookie('cart') ? unserialize(cookie('cart')) : array();
        	//将数据组装成想要的格式 商品id-商品属性ids=>商品数量
        	$key=$goods_id.'-'.$goods_attr_ids;
        	//判断 cookie 中有没有 相关信息   
        	if ($cart_data[$key]) {
        		# cookie存在相关记录 修改其购买数量
        		$cart_data[$key]+=$number;
        	} else {
        		# cookie不存在相关记录 则需要添加
        		$cart_data[$key]=$number;
        	}
        	//把数组序列化 保存在cookie
        	cookie('cart',serialize($cart_data));
        	return true;
        }
    }
    //获取购物车所有数据 
    public function getAllCart(){
    	//需要判断登录状态
    	if (session('?user_info')) {
    		//需要根据user_id 已经登录 直接查询数据表 tpshop_cart表
    		//只获取当前用户的 购物车数据
    		$user_id = session('user_info.id');
    		$return = $this->where(array('user_id' => $user_id))->select();
    	} else {
    		//未登录 从cookie中获取 
    		$cart_data = cookie('cart') ? unserialize(cookie('cart')) : array();
    		// dump($cart_data);
    		foreach ($cart_data as $k => $v) {
    			$temp = explode('-',$k);
    			$row['goods_id'] = $temp[0];
    			$row['goods_attr_ids'] = $temp[1];
    			$row['number'] = $v;
    			$return[] = $row;
    		}
    	}
    	return $return;
    }

    //ajax 请求 查询购物车 商品数量总和
	public function getNumber(){
		//获取购物车总数据 累加其中的购买数量
		$data=$this->getAllCart();
		$total_number = 0;
		foreach ($data as $k => $v) {
			$total_number += $v['number']; 
		}
		return $total_number;
	}

	//修改购物车中一行记录的购买数量
	public function changeNumber($goods_id,$goods_attr_ids,$number){
		//判断登录状态
		if (session('?user_info')) {
			// 登录 取出 当前这条数据
			$user_id = session('user_info.id');
			//查询条件 唯一确定的一条记录 
			$where = array(
				'user_id'=>$user_id,
				'goods_id'=>$goods_id,
				'goods_attr_ids'=>$goods_attr_ids,
				);
			//查询并修改数量
			$data=$this->where($where)->find();
			$data['number'] =$number;//修改商品数量
			$res = $this->save($data);
			return $res != false ? true : false;
		} else {
			//未登录 取出cookie中的所有数据
			$cart_data= unserialize(cookie('cart'));
			$key= $goods_id.'-'.$goods_attr_ids;
			//修改cookie 中的数据 修改指定 记录的数量
			$cart_data[$key] = $number;
			//将数据重新保存在cookie中
			cookie('cart',serialize($cart_data));
			return true;
		}
		
	}

	//删除购物车数据的方法
	public function delcart($goods_id,$goods_attr_ids){
		//判断登录状态
		if (session('?user_info')) {
			$user_id=session('user_info.id');
			$where=array(
				'user_id'=>$user_id,
				'goods_id'=>$goods_id,
				'goods_attr_ids'=>$goods_attr_ids,
				);
			$this->where($where)->delete();
		} else {
			//未登录 删除 cookie 中的一条数据
			$cart_data=unserialize(cookie('cart'));
			//将当前购物车数据 构建 $key
			$key= $goods_id.'-'.$goods_attr_ids;
			unset($cart_data[$key]);//删除 指定$key 的数据
			//重新保存cookie
			cookie('cart',serialize($cart_data));
		}
	}

	// 登录时 将cookie 中购物车数据添加到数据库中
	public function cookieTodb(){
		//取出数据
		$cart_data = cookie('cart') ? unserialize(cookie('cart')) : array();
		//遍历
		foreach ($cart_data as $k => $v) {
			$temp=explode('-',$k);
			$goods_id=$temp[0];
			$goods_attr_ids=$temp[1];
			$number=$v;
			//这里也是一个添加购物车的功能 只针对 登录状态
			$this->addCart($goods_id,$number,$goods_attr_ids);
			//清空cookie 中购物车的数据
			cookie('cart',null);
		}
	}
}