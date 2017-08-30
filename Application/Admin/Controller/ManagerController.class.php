<?php 
namespace Admin\Controller;
use Think\Controller;
class ManagerController extends CommonController{
	//角色列表
	public function index(){
		$title="管理员列表页";
		$this->assign('title',$title);
		//实例化模型对象 //查询数据  连表查询 manager 与 role 表联合查查询 通过role_id
		$data= D('manager')->alias('t1')->field('t1.*,t2.role_name')->join('left join tpshop_role t2 on t1.role_id = t2.role_id')->select();
		//给视图模板赋值
		$this->assign('data',$data);
		$this->display();
	}
	//添加add 方法
	public function add(){
		//处理两个业务逻辑 一个展示页面 一个是添加页面
		if (IS_POST) {
			//接收所有数据
			$data=I('post.');

			// //添加 添加时间 当前时间
			// $data['create_time']=time();
			//实例化模型
			$model=D('Manager');
			if(!$model->create($data)){
				$error=$model->getError();
				$this->error($error);
			}
			//调用add()方法 完成添加
			$res=$model->add();
			//判断成功与否
			if ($res) {
				//添加成功
				$this->success("添加成功",U('Admin/Manager/index'));
			}else{
				//添加失败
				$this->error("添加失败");
			}
		}else{

			$role= M('Role')->select();
			// dump($role);

			$this->assign('role',$role);
			$this->display();
		}
		
	}
	//修改 管理员信息
	public function edit(){
		$title="管理员信息修改页面";
		$this->assign('title',$title);
		//一个方法 两个业务逻辑 一个是显示 管理员信息 一个是 修改后表单提交处理
		if(IS_POST){
			$data=I('post.');
			$data['update_time']=date('Y-m-d H:i:s',time());
			$res= D('Manager')->save($data);
			if($res !==false ){
				$this->success('修改成功',U('Admin/Manager/index'));
			}else{
				$this->error('修改失败');
			}
		}else{//展示待修改管理员信息页面
			$manager_id=I('get.id');
			$manager=M('Manager')->find($manager_id);
			$role = D('Role')->select();
			$this->assign('manager',$manager);
			$this->assign('role',$role);
			$this->display();
		}
	}
	//删除管理员
	public function delete(){
		//获取传递ID
		$id=I('get.id');
		//实例化模型 并调用delete() 方法 删除数据
		$res=D('Manager')->delete($id);
		//判断删除成功与否
		if ($res!==false) {
			$this->success('删除成功',U('Admin/Manager/index'));
		}else{
			$this->error('删除失败');
		}
	}

}
