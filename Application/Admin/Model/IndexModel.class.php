<?php 
namespace Admin\Model;
use Think\Model;
class IndexModel extends Model{
	//模型类的属性和方法
	//
	//避免在html页面（添加和修改页面）暴露数据表字段信息，可以使用字段映射。
   // protected  $_map = array(
   //          'name'=>'goods_name',
   //          'price'=>'goods_price',
   //          'number'=>'goods_number',
   //          //'introduce'=>'goods_introduce',
   //      );

	//自动验证
	protected $_validate=array(
		// array(验证字段1,验证规则,错误提示,[验证条件,附加规则,验证时间])
		array('nickname','','昵称已经存在',0,'unique',3),
		array('password','require','密码不能为空',0,'',3),
		
		);
	//自动完成规则
	protected  $_auto=array(
		// array(完成字段1,完成规则,[完成条件,附加规则]), 
		array('password','encrypt_password',1,'function'),
		array('update_time','date',1,'function'),
		);
}