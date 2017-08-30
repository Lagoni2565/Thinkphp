<?php 
namespace Admin\Controller;
use Think\Controller;
// use Admin\Model\GoodsModel;
class TestController extends CommonController{
	public function index(){
		//普通方式实例化对象
		// $model = new \Admin\Model\GoodsModel();
		// 
		// D()函数快速创建对象
		// $model= D("Goods");//传递参数（模型名称） 实例化Goods模型 关联tpshop_goods 数据表
		// $model= D();//不传递参数 实例化父类模型 不关联数据表
		
		//M函数
		// $model= M('Goods');//传递参数  参数数据表的名称
		// $model=	M();//不传递参数 实例化父类
		// 
		// $model=M('Advice',null);//关联 无前缀的数据表 通过第二个参数设置前缀
		// $model=M('Advice','tp_');//查找tp_advice 数据表
		$model=D('Goods');

		// $data=$model->select(1);
		//select(参数) 查询主键为参数的数据 不传参 表示查询所有
		// $data=$model->select('2,3,4'); //查询指定多条语句
		//SELECT * FROM `tpshop_goods` WHERE `id` IN ('2','3','4')
		//find方法
		// $data = $model->find();//不传参 原生sql语句
		//SELECT * FROM `tpshop_goods` LIMIT 1
		//
		$data = $model->find(2);//传递一个数字 查询指定主键的数据 
		//SELECT * FROM `tpshop_goods` WHERE `id` = 2 LIMIT 1 
		 dump($data);

	}
	public function zhanshi(){
		//普通字符串
		// $name="kongkong";
		//给视图变量赋值
		// $this->assign('name',$name);
		//调用视图文件
		// $this->display();
		// $data=
		$data=array(
			array('id'=>1,'goods_name'=>'test1','goods_time'=>'1456781'),
			array('id'=>2,'goods_name'=>'test2','goods_time'=>'1456781'),
			array('id'=>3,'goods_name'=>'test3','goods_time'=>'1456781'),
			);
		$this->assign('data',$data);
		$this->display();
	}

	public function test_curl(){
		//*************U函数
		$url = U('Home/Cart/ajaxgetnum','','',true);
		dump($url);
		//发送post请求
		$res = curl_request($url,true);
		dump($res);
	}
}