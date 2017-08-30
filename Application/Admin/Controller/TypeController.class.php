<?php 
namespace Admin\Controller;

class TypeController extends CommonController{
	//商品类型列表首页
	public function index(){
		$type=D('Type') -> select();
		// dump($type);
		$this->assign('type',$type);
		$this->display();
	}
	//商品类型添加
	public function add(){
		//一个方法 完成两个 业务逻辑 一个展示添加页面 一个是添加提交后处理
		if (IS_POST) {
			$data= I('post.');
			// dump($data);
			//字段检测 不能为空
			if (empty($data['type_name'])) {
				$this->error('必填项不能为空');
			}
			//保存在数据库中
			$res=D('Type')->add($data);
			if ($res ) {//判断保存成功与否
				$this->success('添加成功',U('Admin/Type/index'));
			}else{
				$this->error('添加失败');
			}
		}else{
			$this->display();
		}
		
	}
	//修改功能
	public function edit(){
		//一个方法 完成两个业务逻辑 一个展示 另一个 接收提交
		if (IS_POST) {
			$data=I('post.');
			$res=D('Type')->save($data);
			if ($res ) {
				$this->success('修改成功',U('Admin/Type/index'));
			}else{
				$this->error('修改失败！');
			}
		}else{
			$type_id=I('get.type_id');
			$type=D('Type')->find($type_id);
			$this->assign('type',$type);
			$this->display();
		}
	}
	//删除功能
	public function delete(){
		$type_id=I('get.type_id');
		$res=D('Type')->delete($type_id);
		if ($res !== flse) {
			$this->success('删除成功',U('Admin/Type/index'));
		}else{
			$this->error('删除失败');
		}
	}
}