<?php 
namespace Admin\Model;
use Think\Model;
class ManagerModel extends Model{
	//模型类的属性和方法
	
	//自动验证
	protected $_validate=array(
		// array(验证字段1,验证规则,错误提示,[验证条件,附加规则,验证时间])
		array('username','require','用户名不能为空',0,'',3),
		array('nickname','','昵称已经存在',0,'unique',3),
		array('nickname','require','昵称不能为空',0,'',3),
		array('password','require','密码不能为空',0,'',3),
		array('confpwd','password','确认密码不正确',0,'confirm'), // 验证确认密码是否和密码一致
		array('email','require','邮箱不能为空',0,'',3),
		);
	//自动完成规则
	protected  $_auto=array(
		// array(完成字段1,完成规则,[完成条件,附加规则]), 
		array('create_time','time',1,'function'),//自动添加 添加时间
		
		array('password','encrypt_password',1,'function'),
		);
}