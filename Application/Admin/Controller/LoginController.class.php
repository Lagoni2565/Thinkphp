<?php 
namespace Admin\Controller;
use Think\Controller;
class LoginController extends Controller{

	public function login(){
		// 一个方法 处理两个业务逻辑
		// 判断登录
		if (IS_POST) {
			
			//获取提交数据
			$data=I('post.');
			//判断验证码 调用verity类的check 方法
			$verify = new \Think\Verify();
			//自动验证 验证码 
			$check=$verify->check($data['verify']);
			if (!$check) {
				$this->error('验证码错误');
			}

			//实例化模型
			$model=D('Manager');
			//查找数据库用户名存不存在
			$manager=$model->where(array('username'=>$data['username']))->find();

			if ($manager && $manager['password']==encrypt_password($data['password'])) {
				
				//用户存在 并且密码正确
				session('manager_info',$manager);

				$this->success("登录成功",U('Admin/Index/index'));//登陆成功跳转首页
			}else{
				$this->error('登录失败');
			}
		}else{
			//展示 登录页面
			$this->display();
		}
		
	}
		
	//退出 操作
	public function logout(){
		//删除所有session
		session(null);
		//退出跳转都登录页面
		$this->redirect('Admin/Login/login');
	}

	//生成验证码
	public function captcha(){
			//实例化验证码类
			$config=array(
				 // 'useImgBg'  =>  true,           // 使用背景图片 
				 'length'    =>  4,               // 验证码位数
				 'useCurve'  =>  false,            // 是否画混淆曲线
        		 'useNoise'  =>  false,            // 是否添加杂点	
				);
			//实例化验证码类
			$verify= new \Think\Verify($config);
			//调用entry() 方法生成并输出验证码
			$verify->entry();
	}

	//ajax 登录
	public function ajaxlogin(){
		//获取ajax 传递数据
		$data=I('post.');
		//判断验证码
		$verify = new \Think\Verify();
		$check = $verify -> check($data['code']);
		if(!$check){
			//返回错误信息
			$return = array(
				'code'=>10001,
				'msg' =>'验证码错误',
				'data'=>$data['code'],
				);
			$this->ajaxReturn($return);
		}

		//判断用户名和密码
		//查询账户存在与否
		$model=D('Manager');
		$manager=$model->where( array('username'=>$data['username']) ) -> find();

		if($manager && encrypt_password( $data['password'] == $manager['password'])){
			//用户存在且输入密码正确
			//将登录用户的信息存入 session 确认登录
			session('manager_info',$manager);
			//将登录时间添加到数据库中
			$model->where( array('id'=>$manager['id']) )->save( array('last_login_time'=> time() ));
			//返回成功信息
			$return = array(
				'code' => 10000,
				'msg'  =>'success',
				);
			$this->ajaxReturn($return);
		}else{
			//登录失败
			//返回失败信息
			$return = array(
				'code'=>10002,
				'msg' =>'密码或用户名错误',
				'data'=>$data['code'],
				);
			$this->ajaxReturn($return);
		}
	}

}