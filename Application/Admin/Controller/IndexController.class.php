<?php 
namespace Admin\Controller;
use Think\Controller;
class IndexController extends CommonController{
	
	public function index(){
		// $password=123456;
		// echo encrypt_password($password);
		// die;
		// echo count('abc');
		// die;
		$this->display();
	}
	//修改密码
	public function repwd(){
		//一个方法处理两个 业务逻辑 一个是展示 账户名密码 邮箱等信息 另一个 重置提交密码处理
		if (IS_POST) {
			//获取表单提交
			$data=I('post.');

			//根据表单提交隐藏域中 id 值 查找用户账户信息
			$manager=D('Manager')->find($data['id']);
			//判断用户 输入的旧密码 与数据库中的密码 是否一致
			if ($manager['password'] == encrypt_password($data['oldpwd'])) {
				//若输入旧密码 和 数据库中的密码一致 则允许修改
			
				//新密码 和 旧密码 不能一致
				if ($manager['password'] == encrypt_password($data['password'])) {
					$this->error('不能使用近期使用过的密码！');
				} 
				//判断输入的新密码和确认密码是否一致
				if ($data['password'] == $data['confpwd']) {//一致
					//删除 提交表单中无用元素
					unset($data['oldpwd']);
					unset($data['confpwd']);
					// 给上传的新密码加密
					$data['password'] = encrypt_password($data['password']);
					//将数据保存 如数据库
					$res=D('Manager')->save($data);	
					if ($res) {
							// 1.直接跳转到 登录页面
							// $this->success('修改成功，需重新登录！',U('Admin/Login/login'));
							// 2.将修改后的管理员信息 存入session中 
							$manager = M('Manager')->find($id);
							session('manager_info',$manager);
							$this->success('修改成功！',U('Admin/Index/index'));
						} else {
							$this->error('修改失败！');
						}
				} else {//不一致
					$this->error('输入确认密码不正确','',2);
				}			
			} else {
				# 输入的密码和旧密码 不一致 
				$this->error('输入的原始密码错误');
			}
		} else {
			//将用户信息展示出来
			$id=I('get.id');
			$data=M('Manager')->find($id);
			$this->assign('data',$data);
			$this->display();
		}	
	}
	//重置密码
	public function resetpwd(){
		$id=I('get.id');
		$data['id'] = $id;
		$data['password'] = encrypt_password('123456');
		$res=D('Manager')->save($data);
		if($res){
			$this->success('重置成功！',U('Admin/Manager/index'));
		}else{
			$this->error('重置失败！');
		}
	}
}