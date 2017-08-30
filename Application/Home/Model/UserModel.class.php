<?php 
namespace Home\Model;
use Think\Model;
class UserModel extends Model
{
	//自动验证
	protected $_validate = array(
		//使用邮箱验证注册时 验证邮箱
		array('email','require','邮箱字段不能为空！'),
		array('email','email','邮箱格式不正确！'),
		array('email','','邮箱已被注册！',0,'unique'),
		//使用手机号注册时 验证手机号
		array('phone','require','手机号不能为空！'),
		array('phone','/^\d{11}$/','手机号格式不正确！'),
		array('phone','','手机号已被注册！',0,'unique'),
		//密码相关验证
		array('password','require','密码不能为空'),
		array('repassword','password','两次密码不一致',0,'confirm'),
		);
	protected $_auto=array(
		array('create_time','time',1,'function'),
		array('password','encrypt_password',3,'function'),
		);
}