<?php 
namespace Admin\Controller;
use Think\Controller;
class AuthController extends CommonController{
	//添加显示列表方法
	public function index(){
		$auth= M('Auth')->select();
		$auth = getTree($auth);
		$this->assign('auth',$auth);
		$this->display();
	}

	//添加添加方法
	public function add(){
		//一个方法 处理两个业务逻辑
		if (IS_POST) {
			$data=I('post.');
			//可以添加字段 自动验证 自动完成等
			$res= M('Auth')->add($data);
			if($res){
				$this->success('添加成功',U('Admin/Auth/index'));
			}else{
				$this->error('添加失败');
			}
		}else{
			//查询 所有顶级权限信息 用于显示页面
			$top=M('Auth')->where('pid=0')->select();
			$this->assign('top',$top);
			$this->display();
		}
		
	}
	//删除权限
	public function delete(){
		$id=I('get.id');
		$res=D('Auth')->delete($id);
		if ($res!== false) {
			$this->success('删除成功',U('Admin/Auth/index'));
		}else{
			$this->error('删除失败');
		}

	}
	//编辑 权限  先把旧数据显示出来 修改后数据提交 保存进数据库
	public function edit(){
		if (IS_POST) {
			// 接收 表单提交数据
			$data=I('post.');
			//若将子权限中的目录修改成 顶级目录 则要去除控制器和方法
			if($data['pid']==0){
				$data['auth_c']='';
				$data['auth_a']='';
			}
			
			// dump($data);
			$res=D('Auth')->save($data);
			if ($res) {
				$this->success('修改成功！',U('Admin/Auth/index'));
			} else {
				$this->error('修改失败');
			}
			

		} else {
			$id=I('get.id');
			$data=M('Auth')->find($id);
			$top=M('Auth')->where( 'pid=0' )->select();
			$second=M('Auth') -> where('pid>0')->select();
			//将$top中的 id 组成字符串 传递到模板中
			foreach ($top as $key => $value) {
				$id1[]=$value['id'];
			}
			// dump($data);
			$str=implode(',', $id1);//将$id1 数组转化成字符串 并赋值到模板变量

			$this->assign('str',$str);
			$this->assign('data',$data);
			$this->assign('top',$top);
			$this->assign('second',$second);
			//展示视图文件
			$this->display();
		}
		
		
	}

}