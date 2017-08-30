<?php 
namespace Admin\Controller;
use Think\Controller;
class AttributeController extends CommonController{
	//添加显示列表方法
	public function index(){
		$attr=D('Attribute')->alias('t1')->join("left join tpshop_type t2 on t1.type_id=t2.type_id ")->select();
		// dump($attr);
		$this->assign('attr',$attr);
		$this->display();
	}
	//添加添加方法
	public function add(){
		if (IS_POST) {
			$data=I('post.');//接收添加提交数据
			$res=D('Attribute')->add($data);
			if ($res) {
				$this->success('添加成功',U('Admin/Attribute/index'));
			}else{
				$this->error('添加失败');
			}
		}else{
			//查询 商品类型表 获取所有商品类型 
			$type=D('Type')->select();
			$this->assign('type',$type);
			$this->display();
		}
	}
	//商品属性编辑
	public function edit(){
		if(IS_POST){
			$attr=I('post.');
			// dump($attr);
			// die;
			$res= D('Attribute') -> save($attr);
			if ($res) {
				$this->success('修改成功',U('Admin/Attribute/index'));
			}else{
				$this->error('修改失败');
			}
		}else{
			$attr_id=I('get.attr_id');
			$attr=D('Attribute')->find($attr_id);
			$type=D('Type')->select();
			// dump($attr);
			$this->assign('attr',$attr);
			$this->assign('type',$type);
			$this->display();
		}
		
	}
	//商品属性删除
	public function delete(){
		$attr_id=I('get.attr_id');
		if (D('Attribute')->delete($attr_id)) {
			$this->success('删除成功',U('Admin/Attribute/index'));
		}else{
			$this->error('删除失败');
		}
	}
}