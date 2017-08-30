<?php 
namespace Admin\Controller;
use Think\Controller;
class RoleController extends CommonController{
	//角色显示列表方法
	public function index(){
		//实例化模型对象
		$role=M('Role')->select();
		$this->assign('role',$role);
		$this->display();
	}
	//添加角色
	public function add(){
		if (IS_POST) {
			$data=I('post.');
			$model=D('Role');
			// if($model->create($data)){
			// 	$error=$model->getError();
			// 	$this->error($error);
			// }
			$res=$model->add($data);
			if($res){
				$this->success("操作成功",U('Admin/Role/index'));
				//第三个参数默认1s
			}else{
				$this->error("添加失败");
				//第二个参数 跳转地址 不填返回之前页面
			}
		}else{
			$this->display();	
		}
	}

	//删除角色
	public function delete(){
		$id=I('get.role_id');
		$model= D('Role');
		$res = $model->where( array('role_id'=>$id) )->delete();
		if ($res !==false) {
			$this->success("删除成功",U('Admin/Role/index'));
		}else{
			//失败
			$this->error('删除失败');
		}
	}

	//权限管理 分配权限 
	public function setauth(){
		//一个方法 处理两个逻辑 一个是显示rolr_id 已有的权限  一个值修改权限提交
		if (IS_POST) {
			$data =I('post.');
			// array(2) {
			// 		  ["role_id"] => string(1) "2" 
			// 		  ["id"] => array(2) {
			// 		    [0] => string(1) "2"
			// 		    [1] => string(1) "3"
			// 		  }
			// 		}
			if(empty($data['id'])){
				$this->error('此操作无效！');
			}
			
			$role['role_id']=$data['role_id'];
			//权限 ids 处理 组装成 字符串 形式
			$role['role_auth_ids']=implode(',', $data['id']);
			
			//查询权限信息 (提交表单权限 信息 在auth表中 )
			// $auth = D('Auth')->where('id in ('.$role['role_auth_ids'].')')->select();//返回二维数组
			$auth = D('Auth')->where("id in ({$role['role_auth_ids']})")->select();//返回二维数组
			//遍历二维数组  组装我们想要的 字符串形式 控制器-方法名,控制器-方法名。。
			foreach ($auth as $key => $value) {
				//若 $value['auth_c'] 和 $value['auth_a'] 存在
				if ($value['auth_c'] &&  $value['auth_a'] ) {
					$role['role_auth_ac'].=$value['auth_c'].'-'.$value['auth_a'].',';
				}
			}
			//循环结束 我们得到的 $role['rolr_auth_ac'] 字符串 最右边会 多一个 ,
			$role['role_auth_ac']= rtrim($role['role_auth_ac'],',');
			//实例化 角色模型保存角色权限信息
			$res = M('Role')->save($role);
			if ($res !== false ) {
				//保存成功 返回 分配权限页
				$this->success('保存成功',U('Admin/Role/setauth',array('role_id'=>$data['role_id'])));
			}else{//保存失败
				$this->error('');
			}

		}else{
			//显示
			//查询角色信息 接收get 传递 role_id ={$vol.role_id} 值 显示已有权限
			$role_id= I('get.role_id');
			$role=M("Role")->find($role_id);//得到一维数组
			
			//查询所有的 顶级权限 和二级权限 目的：让视图模板显示 遍历显示菜单项
			$top=M('Auth')->where( 'pid=0' )->select();
			$second=M('Auth')->where( 'pid > 0' )->select();
			//给视图模板赋值
			$this->assign('role',$role);//展示的数据
			$this->assign('top',$top);
			$this->assign('second',$second);
			//调用视图模板
			$this->display();
		}
	}
}