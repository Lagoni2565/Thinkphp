<?php 
//声明命名空间
namespace Admin\Model;
//引入父类模型
use Think\Model;
//定义模型类
class GoodsModel extends Model{
//	//模型类的属性和方法
//    protected  $field =array('id','goods_name','goods_price','goods_number');
//    //指定主键字段 默认使用id
//    protected  $pk='id';
//    
//避免在html页面（添加和修改页面）暴露数据表字段信息，可以使用字段映射。
   protected  $_map = array(
            'name'=>'goods_name',
            'price'=>'goods_price',
            'number'=>'goods_number',
            //'introduce'=>'goods_introduce',
        );
	//自动验证
	protected $_validate=array(
		// array(验证字段1,验证规则,错误提示,[验证条件,附加规则,验证时间])
		array('goods_name','require','商品名称不能为空',0,'',3),
		array('goods_price','require','商品价格不能为空',0,'',3),
		array('goods_price','currency','商品价格 格式不正确',0,'',3),
		array('goods_number','require','商品数量不能为空',0,'',3),
		array('goods_number','number','商品数量格式正确',0,'',3),
		);
	//自动完成规则
	protected  $_auto=array(
		// array(完成字段1,完成规则,[完成条件,附加规则]), 
		array('goods_create_time','time',1,'function'),//自动添加 添加时间
		// array('goods_update_time','date',1,'function'),//自动添加 添加时间
		// array('password','MD5',1,'function'),//密码加密
		);

	//封装一个方法 用于单文件上传商品logo 修改
	public function upload_logo(&$data,$file){
		// dump($data);
		// dump($file);
		// die;
		//商品logo图片上传
		//判断from 表单文件上传过程是否报错 0 没有错误
		if (empty($file) || $file['error'] != 0) {
			//若没有文件 可以上传
			return false;
		}
		
			//配置文件
			$config=array(
			'maxSize'    =>    5*1024*1024,//    
			'rootPath'   =>    WEB_ROOT.UPLOAD_PATH,    
			'exts'       =>    array('jpg', 'gif', 'png', 'jpeg'),   
			);
			//实例化文件上传类
			$upload= new \Think\Upload($config);
			//上传单个文件 成功一维数组 失败 false
			$info = $upload->uploadOne($_FILES['logo']);
			if (!$info) {//上传失败
				return false;
			}else{//上传成功 一维数组
				//将文件保存路径拼接出来 放入$data 中 后面的 添加方法 会将图片路径 保存到数据库中
				$data['goods_big_img']=UPLOAD_PATH.$info['savepath'].$info['savename'];
				
				//给商品logo图片生成缩略图(原图片上传之前)
				$image= new \Think\Image();
				//调用open方法 参数 图片的磁盘路径 
				$image->open(WEB_ROOT.$data['goods_big_img']);
				//调用thumb方法 生成缩略图 参数为最大 宽高
				$image->thumb(188,188);
				//调有save 方法 保存缩略图 参数 图片地址 需要从磁盘开始的真实路径
				//构建缩略图存入数据库 路径信息字符串  在文件名前加 thumb 字符串
				$data['goods_small_img']=UPLOAD_PATH.$info['savepath'].'thumb'.$info['savename'];
				//保存缩略图 把缩略图保存到指定文件夹内
				$image->save(WEB_ROOT.$data['goods_small_img']);
				//上传成功返回 true
				return true;
			}
		}


		//封装一个upload_pics方法 完场商品相册的方法
		//上传多个相册图片，给每一个商品生成3张不同 大小规格图片
		public function upload_pics($goods_id,$files){
			//若传递的$file 只要一抔一个文件 没有发生错误 就进行上传
			//取出 错误error 数组中最小值 若最小值为0 则需要上传 不为0  不上传
			// dump($files);

			if(min($files['goods_pics']['error']) != 0){
				return false;
			}

			//配置文件
			$config=array(
			'maxSize'    =>    20*1024*1024,//    
			'rootPath'   =>    WEB_ROOT.UPLOAD_PATH,    
			'exts'       =>    array('jpg', 'gif', 'png', 'jpeg'),   
			);
			//实例化文件上传类
			$upload= new \Think\Upload($config);
			//上传多个个文件 成功二维数组 上传成功的 在数组中 失败 的被抛弃
			$res = $upload->upload($files);
			// dump($res);
			// die;
			if (!res) {
				//若 上传的每一个图片 都没有成功
				return false ;
			}
			//若成功 则
			//遍历 $res 对每一个文件信息 保存原始图片的路径 
			//生成缩略图 保存缩略图的储存路径
			foreach ($res as $key => $value) {
				//上传的图片原始路径
				$row['pics_origin']=UPLOAD_PATH.$value['savepath'].$value['savename'];
				//商品id 也放到$row 中
				$row['goods_id']=$goods_id;
				//生成缩略图
				$image= new \Think\Image();
				//调用open方法 参数 图片的磁盘路径 
				$image->open(WEB_ROOT.$row['pics_origin']);

				//生成大图 调用thumb方法 生成缩略图 参数为最大 宽高
				$image->thumb(800,800);
				//调有save 方法 保存缩略图 参数 图片地址 需要从磁盘开始的真实路径
				//构建缩略图存入数据库 路径信息字符串  在文件名前加 thumb 字符串
				$row['pics_big']=UPLOAD_PATH.$value['savepath'].'thumb_800_'.$value['savename'];
				//保存缩略图 把缩略图保存到指定文件夹内
				$image->save(WEB_ROOT.$row['pics_big']);

				//生成中图
				$image->thumb(350,350);
				$row['pics_mid']=UPLOAD_PATH.$value['savepath'].'thumb_350_'.$value['savename'];
				$image->save( WEB_ROOT.$row['pics_mid'] );

				//生成小图
				$image->thumb(50,50);
				$row['pics_sma']=UPLOAD_PATH.$value['savepath'].'thumb_50_'.$value['savename'];
				$image->save( WEB_ROOT.$row['pics_sma'] );
				//将$row 添加到goodspics表 中 
				M('Goodspics') -> add($row);
			}

			//上传成功返回 true
			   return true;
		}
}
