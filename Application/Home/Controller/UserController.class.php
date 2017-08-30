<?php
namespace Home\Controller;
use Think\Controller;
class UserController extends Controller {
   //注册
	 public function register(){
	 	if (IS_POST) {
	 		$data=I('post.');
            // 手机注册
            if (isset($data['phone'])) {
                //手机验证码的有效期
                $sendtime= session('?sendtime') ? session('sendtime') :0;
                if (time() - $sendtime >300 ) {
                    //过期 销毁存在session 中的 手机验证码
                    session('register_code'.$phone,null);
                    $this->error('验证码已经失效');
                 } 
                //验证 验证码的正确性
                if (session('register_code'.$data['phone']) != $data['code']) {
                   $this->error('短信验证码不正确');
                }else{
                    //验证通过 让验证码失效
                    session('register_code'.$data['phone'],null);
                    //手机验证成功后 用户可以登录 状态 改为1 
                    $data['is_check'] = 1;
                }
            }
            //邮箱注册
            if (isset($data['email'])) {
               //生成一个验证码保存在数据库中
               $email_code = rand(1000,9999);
               $data['email_code'] = $email_code;
            }

	 		$data['username'] = $data['phone'] ? $data['phone'] : $data['email'] ;
	 		$model=D('User');
	 		//使用create 自动创建数据集 会自动验证等功能
	 		if (!$model->create($data)) {
	 			$error=$model->getError();
	 			$this->error($error);
	 		}
            //调用add()方法 将注册信息添加到数据库
	 		$res=$model->add();
	 		if ($res) {
                //注册成功时
                //如果是 邮箱注册，需要发送激活邮件 邮件中需要回传用户id 和验证码
                if (isset($data['email_code'])) {
                   $email = $data['email'];
                   $subject= '欢迎注册商城，激活邮件';
                   $url=U('Home/User/jihuo',array('id'=>$res,'code'=>$email_code),'.html',true);
                   $body="点击以下链接进行激活：<br/><a href='{$url}'> {$url}</a><br/>若无法打开请复制链接地址在浏览器直接打开！";
                   $send_res = sendmail($email,$subject,$body);
                   // dump($send_res);die;
                   if ($send_res !== true) {
                       //激活邮箱失败
                       $this->error('账号激活邮件发送失败，请重试');
                   }
                }
                $this->success('注册成功',U('Home/User/login'));
	 		}else{
	 			$this->error('注册失败');
	 		}
	 	}else{
	 		//对当前模板关闭模板布局
		 	layout(false);
            if (session('?user_info')) {
                $this->redirect('Home/Index/index');
            }
	        $this->display();
	 	}	
    }

    //登录功能
    public function login(){

    	if(IS_POST){
    		//接收数据之后
    		$data=I('post.');
    		// dump($data);die;
    		//字段检测
    		if ( empty($data['username']) || empty($data['password']) ) {

    			$this->error('用户名和密码不能为空');
    		}
    		$username= $data['username'];
    		// dump($username);die;
    		//根据用户名查询数据库
    		$user = D('User')->where("username = '{$username}' or email='{$username}' or phone='{$username}'")->find();
    		
    		if ($user && $user['password'] == encrypt_password($data['password'])) {
                //激活状态
                if ($user['is_check'] != 1 ) {
                //用户需要先激活邮箱才能登陆
                $this->error('账户还未激活');
            }
    			//登录成功将 最后登录时间记录到数据表中
    			$log['last_login_time']=time();
    			$log['id']=$user['id'];
    			D('User')->save($log);

    			//登录成功设置登录标识到session中
    			session('user_info',$user);
                //在登录成功 设置登录表示之后 调用cart模型 的添加购物车 方法迁移cookie数据
                D('Cart')->cookieTodb();
                //登陆成功 跳转地址
                $back_url=session('?back_url') ? session('back_url') : U('Home/Index/index');
    			$this->success('登陆成功',$back_url);
    		}else{
    			$this->error('登录失败,用户名或密码错误！');
    		}

    	}else{
    		//判断用户是否已经登录 已登录直接 跳转首页
    		if (session('?user_info')) {
    			$this->redirect('Home/Index/index');
    		}
			//关闭 全局模板布局
    		layout(false);
			$this->display();
    	}
    	
	}

    //退出功能
    public function logout(){
    	session(null);
    	$this->redirect('Home/Index/index');
    }
    //邮箱激活地址
    public function jihuo(){
        $data = I('get.');
        $user_id = $data['id'];
        $code = $data['code'];
        if ($user_id && $code){
            $user = D('User')->find($user_id);
            if (empty($user)) {
                $this->error('用户不存在');
            }
            //校验验证码
            if ($user['email_code'] != $code ) {
               $this->error('验证码不正确',U('Home/User/register'));
            }else{
                //激活用户
                $user['is_check'] = 1;
                D('User')->save($user);
                $this->success('激活成功',U('Home/User/login')); 
            }
        }else{
            $this->error('激活参数不对',U('Home/User/register'));
        }
    }
}
