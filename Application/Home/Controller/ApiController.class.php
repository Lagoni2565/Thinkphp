<?php 
namespace Home\Controller;
use Think\Controller;
/**
* 
*/
class ApiController extends Controller
{
	//短信 发送验证码
	public function sendmsg(){
		//获取表单提交验数据
		$phone = I('post.phone');
		// $phone = 15670071911;
		//发送频率限制】
		$sendtime = session('?sendtime') ? session('sendtime') : 0;
		if (time() - $sendtime < 60 ) {
			//发送太频繁
			$return = array(
				'code'=>10003,
				'msg'=>'验证码发送太频繁，请稍后再试'
				);
			$this->ajaxReturn($retrn);
		}
		//生成手机短信验证码
		$code = rand(1000,9999);
		$str = "注册";
		//模板内容
		$content = "【XXXX】您用于{$str}的验证码为{$code}，如非本人操作，请忽略本短信";
		//app key 
		$key = "56094ca4632daa86455f007d61e3b113"; 
		//拼接 请求地址
		$url = "https://way.jd.com/chuangxin/dxjk?mobile={$phone}&content={$content}&appkey={$key}";
		dump($url);
		//发送请求 调用接口
		$res=curl_request($url, false, array(),true);
		dump($res);
		//转化成数组格式
		$result=json_decode($res,true);
		// dump($result);
		if ($result['code']==10001) {
			//请求发送失败
			$return = array(
				'code' => 10001,
				'msg'  =>'服务器异常'
				);
			$this->ajaxReturn($return);
		}
		// die;
		// dump($result);
		if ($result['code'] == 10000) {
			//发送短信成功  将 验证码手机号码 存入session 待判定
			session('register_code'.$phone,$code);
			session('sendtime',time());//将发送验证码的时间记录下来
			$return =array(
				'code' =>10000,
				'msg' =>'短信发送成功'
				);
			$this->ajaxReturn($return);
		}else{
			$return =array(
				'code' =>10002,
				'msg' =>'短信发送失败'
				);
			$this->ajaxReturn($return);
		}

	}

	//
	//
	public function qqcallback()
	{
		require_once("/Application/Tools/qq/API/qqConnectAPI.php");
		$qc = new \QC();
		//获取access_token
		$access_token = $qc->qq_callback();
		//获取openid
		$openid = $qc->get_openid();
		//重新实例化 QC类
		$qc = new \QC($access_token,$openid);
		//获取用户信息
		$info = $qc->get_info();
		$nickname= $info['nickname'];
		// dump($user_info);
		// 添加用户到数据表
		$user = D('User')->where(array('openid'=>$openid))->find();
		if ($user) {
			# 老用户 变更昵称
			$user['username']=$nickname;
			M('User')->save($user);
			session('user_info',$user);
			//跳转效果关闭新窗口原窗口跳转 商城首页
			echo "<script>window.opener.locstion.href='/';</script>" ;
		}else{
			//新用户
			$data = array(
				'username'=>$nickname,
				'openid'=>$openid,
				'create_time'=>time()
				);
			//将新用户数据添加到 数据库
			$res = D('User')->add($data);
			$user = M('User')->find($res);
			session('user_info',$user);
			//注册成功 跳转 商城首页 关闭qq登录页面
			echo "<script>window.opener.location.href='/';window.close()</script>";
		}
	}
	
}