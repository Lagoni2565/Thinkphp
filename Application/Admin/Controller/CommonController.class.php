<?php 
namespace Admin\Controller;
use Think\Controller;
class CommonController extends Controller{
	//构造方法
	public function __construct(){
		//调用父类构造函数  若不调用的话就是将父类的构造方法重写
		parent::__construct();
		//判断session中有没有$manager 
		if (!session('?manager_info')) {
			//没有登录 跳转
			$this->redirect('Admin/Login/login','请先登录！');
		}
		//调用getnav 方法获取左侧权限
		$this->getnav();
		//调用checknav() 方法 检测访问者 有没有范文当前页面的权限
		$this->checkauth();
	}

	//获取左侧菜单权限 
	public function getnav(){
		//若session有权限数据
		if(session('?top')&&session('?second')){
			return ; 
		}
		//从session中获取 role_id
		$role_id= session('manager_info.role_id');
		//判断是否是超级管理员
		if ($role_id==1) {
			//超级管理员 拥有所有权限 直接查询权限表查询
			//顶级权限
			$top= M('Auth') ->where('pid=0 and is_nav = 1 ')->select();
			//耳机权限
			$second = M('Auth') ->where("pid <> 0 and is_nav = 1 ") ->select();
			
		}else{
			//其他管理员 根据role_id 查询角色表 获取 拥有权限的ids字段
			$role = M('Role')->find($role_id);
			$role_auth_ids = $role['role_auth_ids'];
			//从权限表 查询拥有的权限
			//顶级权限
			$top = M('Auth') -> where("pid = 0  and is_nav = 1 and id in ($role_auth_ids)")->select();
			//二级权限
			$second = M('Auth') -> where("pid > 0 and is_nav = 1 and id in ($role_auth_ids)")->select();
		}
		//把查询到的数据保存到session中 
		//管理员登录后 权限变动很少 所以可以这样做 若登陆之后权限发生过改变可以重新登录 一下
		session('top',$top);
		session('second',$second);

	}

	//用来检测权限
	public function checkauth(){
		$role_id=session('manager_info.role_id');
		//超级管理员  role_id=1 不需要检测 就能访问 所有页面
		if ($role_id==1 ) {
			return;
		}else{
			//其他管理员
			//现获取当前要访问的 控制器名和方法名 拼接成一个 控制器-方法名 样式
			//获取当前管	理员所处的角色 所拥有的权限
			$c = CONTROLLER_NAME;//获得访问控制器名
			$a = ACTION_NAME;//获得访问方法名
			$ac=$c.'-'.$a;//拼成 控制器-方法名 字符串
			// echo $ac;
			//1.对于特殊页面 可以特殊处理 比如 index 页面
			//2.后台 首页 对于所有管理员都有权限访问
			//2.对于已经登录的用户 都有访问 修改自己密码的权限
			if (strtolower($ac) == 'index-index' || strtolower($ac) == 'index-logout' || strtolower($ac) == 'index-repwd') {
				return;
			}

			//权限检测  获得角色信息 从role表中取出 下标为 role_auth_ac 的值 为字符串
			$auth = M('Role')->find($role_id);
			// 把role_auth_ac 字符串转化成数组
			$role_auth_ac_arr= explode(',',$auth['role_auth_ac']);
			// dump($role_auth_ac_arr);
			
			if (!in_array($ac,$role_auth_ac_arr)) {
				//没有权限访问 返回后台首页
				$this->error('你没有权限访问！',U('Admin/Index/index'));
			}
		}
	}
}