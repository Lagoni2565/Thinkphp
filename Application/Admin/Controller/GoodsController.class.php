<?php 
namespace Admin\Controller;
use Think\Controller;
class GoodsController extends CommonController{
	//显示列表方法
	public function index(){
		// $phone=15670071911;
		// echo encrypt_phone($phone);
		// 加密
		 // $password= 123456;
		// echo encrypt_password($password);
		// 使用load 时 要把配置文件中的 
		//自动载入自定义文件
    	// "LOAD_EXT_FILE"			=>'str', 注释
		// load('Common/str');
		 //引用自定义类
		 // $page= new \Tools\Page();
		 // echo $page->getName();
		 // die;
		//实例化模型类
		$model=D('Goods');

		//获取分页参数
		$total=$model->count();//总记录数
		$pagesize=5;//每页显示条数 自己设置
		//实例化分页类 来完成分页工作
		$page= new \Think\Page($total,$pagesize);
		//自定义 属性和配置
		$page -> rollPage= 5;// 分页栏每页显示的页数
		$page -> lastSuffix = false; // 最后一页不显示总页数
		$page -> setConfig('prev','上一页');//上一页显示 上一页
		$page -> setConfig('next','下一页');//下一页显示 下一页
		$page -> setConfig('first','首页');//首页显示 首页
		$page -> setConfig('last','尾页');//尾页显示尾页
		$page -> setConfig('theme','%HEADER% %FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END%');
		//显示页码前添加'<span class="rows">共 %TOTAL_ROW% 条记录</span>',
		$page_html=  $page -> show();//调用显示方法 获取html 代码
		$this->assign('page_html',$page_html);//给视图文件赋值
		//查询每页显示数据
		$data= $model -> limit($page->firstRow,$page->listRows)->order('id desc')->select();

		//给模板变量赋值
		$this->assign('data',$data);


		//展示 视图模板文件
		$this->display();
	}

	//商品新增
	public function add(){
		//同一个方法 处理两个业务逻辑一个是展示页面，一个是表单提交
		if (IS_POST) {//判断请求 true 表单提交 post 
			//接收所有数据
			$data=I('post.');//默认htmlspecialchars 处理

			// $data=$_POST;
			// // 使用htmlspecialchars函数防范xss攻击
			// $data['name']= htmlspecialchars($_POST['name']);

			//对添加 商品简介的字段单独处理 去出空格
			// $data['goods_introduce']=I('post.goods_introduce','','trim');

			//使用remove_xss函数(htmlpurifier) 防范xss 攻击
			$data['goods_introduce']=I('post.goods_introduce','','remove_xss');
			
			// 在添加数据之前 完成文件上传 把文件路径保存到$data 中
			//商品logo图片上传
		
			//添加数据到数据表
			$model = D('Goods');

			//调用 模型中封装的 upload_logo方法 实现上传
			$file=$_FILES['logo'];
			$model->upload_logo($data,$file);
			
            //自动创建数据集 
            if(!$model->create($data)){
            	$error = $model->getError();//报错
            	$this->error($error);
            };
			//调用add方法 完成添加 成功返回值为 添加成功的主键 失败false
			//集$res 就是添加成功时 新商品图片的id
			$res=$model->add();
			if($res){
				//添加成功
				//商品相册图片上传 添加成功后才 能上传多图片 因为 
				//goodpics表goods_id 与 goods表 id  相等
				$file = array( 'goods_pics' =>$_FILES['goods_pics']);
				// unset( $_FILES['logo']);//删除$_FILES['logo'] 元素
				// $file=$_FILES;
				// $file['goods_pics'] = $_FILES['goods_pics'];
				//调用模型upload_pics方法 完成添加  
				$model -> upload_pics($res,$file);
				//天商品属性值到 商品属性关联表中 
				//遍历的道德属性数据，组装成一个一个数组添加到 数据表中
				$model1=M('GoodsAttr');
				foreach ($data['attr_value'] as $k => $v) {
					$attr['goods_id'] 	= $res;
					$attr['attr_id']	=$k;
					foreach ($v as $key => $value) {
						$attr['attr_value']=$value;
						//将组装的数组添加到 数据库
						$model1->add($attr);
					}
				}
				// $this->redirect('Admin/Goods/index');直接跳转
				$this->success("操作成功",U('Admin/Goods/index'));
				//第三个参数默认1s
			}else{
				$this->error("添加失败");
				//第二个参数 跳转地址 不填返回之前页面
				//等待时间默认3s
			}
		}else{
			//get 请求，展示页面
			//获取商品类型信息
			$type=D('Type')->select();
			$this->assign('type',$type);
			// dump($type);
			//查询所有商品分类信息
			$category=M('Category')->select();
		    $this->assign('category',$category);
			$this->display();//展示页面
		}
	}

	//添加 详情页
	public function detail(){
		//获取传递id
		$id=I('get.id');
		//获取数据
		$goods=D('Goods')->find($id);
		//dump($goods);die;
		//向模板文件赋值
		$this->assign('goods',$goods);

		//展示图标需要的数据格式
		$data=array(
			array('name' => 'online','data' => array()),
			array('name' => 'offline','data' => array()),
			);
		
		//获取online 的数据 获取二维数组 
		//实例化模型  把数据库中goods_id = $id 的 数据按升序排列取出 
		$online_data=D('Saleonline')-> where(array('goods_id'=>$id))->order ('id asc')->select();
		//遍历二维数组 取出 每条数据中 下标为money 的值
		foreach ($online_data as $key => $value) {
			//将取出的值放入临时数组中 注意 从数据库中取出的数是字符串形式 需要转化成 浮点型
			$temp[]=floatval($value['money']);
		}
		//将临时数组中的值 仿佛我们想 阻止的格式数组中
		$data[0]['data']=$temp;

		//同理我们取出 offline 的数据
		//实例化模型  把数据库中goods_id = $id 的 数据按升序排列取出 
		$offline_data=D('Saleoffline')-> where(array('goods_id'=>$id))->order ('id asc')->select();
		//遍历二维数组 取出 每条数据中 下标为money 的值
		foreach ($offline_data as $key => $value) {
			//将取出的值放入临时数组中
			$temp1[]=floatval($value['money']);
		}
		//将临时数组中的值 仿佛我们想要的格式数组中
		$data[1]['data']=$temp1;

		//将租好的格式数组 转化成json格式 直接在页面输出
		$json_data=json_encode($data);
		$this->assign('json_data',$json_data);
		$this->display();
	}
	//商品信息修改
	public function edit(){
		if (IS_POST) {
			//获取提交数据
			$data=I('post.');
			dump($data);
			//实例化模型
			$model=D('Goods');
		
			//对修改 商品简介的字段单独处理 去出空格
			//$data['goods_introduce']=I('post.goods_introduce','','trim');
			
			//对商品介绍字段做特殊处理 使用remove_xss函数 进行过滤 防范xss攻击
			$data['goods_introduce']=I('post.goods_introduce','','remove_xss');

			
			// 在修改数据提交之前 完成文件上传 把文件路径保存到$data 中
			//商品logo图片上传
			//调用 模型中封装的 upload_logo方法 实现上传
			$file=$_FILES['logo'];
			//调用模型方法 完成图片上传功能
			$model->upload_logo($data,$file);

			//若上传了新图片就查询 旧图片路径 备用待删除
			//看$data['goods_big_img'] 中是否有内容 有的话说明上传了新图片 
			if($data['goods_big_img']){
				//查询原图片信息 保存在$goods 中
				$goods= $model->find($data['id']);
			}

			//使用create() 方法自动创建 数据集
			if( !$model->create($data) ){//自动创建数据集
				//创建失败 获取失败信息
				$error=$model->getError();
				$this->error($error);
			};
			//使用create 方法 之后 这里save 不需要传参数了
			//保存提交数据 save() 返回值 受影响的记录条数
			$res=$model->save();
			
			//判断保存更新后信息是否成功
			if ($res !== false) {
				//成功
				//如果上传了图片 需删除旧图片
				if($goods){
					unlink(WEB_ROOT.$goods['goods_big_img']);
					unlink(WEB_ROOT.$goods['goods_small_img']);
				}

				//继续上传商品相册图片
				$files['goods_pics']= $_FILES['goods_pics'];
				$model->upload_pics($data['id'],$files);

				//修改商品属性值到 商品属性关联表中 
				//遍历得到 属性数据，组装成一个一个数组添加到 数据表中
				$model1=M('GoodsAttr');
				foreach ($data['attr_value'] as $k => $v) {
					$attr['goods_id'] 	= $data['id'];
					$attr['attr_id']	=$k;
					foreach ($v as $key => $value) {
						$attr['attr_value']=$value;
						//将组装的数组添加到 数据库
						$model1->add($attr);
					}
				}
				// dump($data);die;
				$this->success("修改成功",U('Admin/Goods/index'));
			}else{
				//失败
				$this->error('修改失败');
			}
		}else{
			//展示页面
			//查询商品原始数据
			$id=I('get.id');
			//实例化模型类 并调用find()方法 查询一条 数据表的对应主键的 数据
			$goods=D('Goods')->find($id);
			$this->assign('goods',$goods);
			// dump($goods);

			//查询商品 相册图片
			$goodspics = M('Goodspics')->where(array('goods_id'=>$id))->select();
			$this->assign('goodspics',$goodspics);

			//展示商品属性
			$type=M('Type')->select();
			$this->assign('type',$type);//商品类型
			// dump($type);

			// $attr=M('Attribute')->where( array('type_id'=>$goods['type_id']) )->select();
			// $this->assign('attr',$attr);//商品属性
			// dump($attr);die;
			$this->display();
		}
	}
	
	//商品删除
	public function delete(){
		//接收数据
		$id=I('get.id');
		//实例化模型
		$model=D('Goods');
		$goods = $model->find($id);
		//获取 goods表中 id值 与 goodspics 表中 goods_id 相等的元素 返回一维数组 待删除时调用
		$pics=D('Goodspics')->where(array('goods_id'=>$id))->find();
		
		//调用delete 方法删除数据 返回值 受影响的行数 失败返回false
	    $res1=$model->delete($id);
		//删除成功与否判断
		if ($res1 !== false) {
			//成功删除 数据表中的记录
			//删除 存储的图片
			unlink(WEB_ROOT.$goods['goods_big_img']);
			unlink(WEB_ROOT.$goods['goods_small_img']);
			//在删除成功之后相册 中 goods_id = $good['id'] 的图片删除
			//若 相册表中是否存在图片 即$pics 存在 时
			//删除该商品所有的相册图片
            
			$res2=D('Goodspics')->where(array('goods_id'=>$id))->select();
			if($res2 !==false){
				//删除成功
				//删除 该相册图片及缩略图
				foreach ($res2 as $key => $value) {
					unlink(WEB_ROOT.$value['pics_origin']);
					unlink(WEB_ROOT.$value['pics_big']);
					unlink(WEB_ROOT.$value['pics_mid']);
					unlink(WEB_ROOT.$value['pics_sma']);
				}
			}	
			$this->success("删除成功",U('Admin/Goods/index'));
		}else{
			//失败
			$this->error('删除失败');
			}
	}
	//ajax 删除相册图片 
	public function delpics(){
		//接收数据（相册图片的主键id）
		$pics_id = I('post.id');
		//检测主键id是否是一个整数
		if(intval($pics_id) != $pics_id){
			//参数错误
			$return = array(
				'code' => 10002,
				'msg' => '参数错误'
			);
			$this -> ajaxReturn($return);
		}

		//查询要删除的图片的记录信息 原图缩略图路径 后续删除
		$pics = M('Goodspics') -> find($pics_id);

		//删除数据表中的记录
		$res = M('Goodspics') -> delete($pics_id);
		if($res !== false){
			//删除成功
			//删除四张图片
			unlink(WEB_ROOT . $pics['pics_origin']);
			unlink(WEB_ROOT . $pics['pics_big']);
			unlink(WEB_ROOT . $pics['pics_mid']);
			unlink(WEB_ROOT . $pics['pics_sma']);
			//返回数据
			$return = array(
				'code' => 10000,
				'msg' => 'success'
			);
			$this -> ajaxReturn($return);
		}else{

		//返回，删除失败
			$return = array(
				'code' => 10001,
				'msg' => '删除失败'
			);
			$this -> ajaxReturn($return);
		
		}
	}

	//ajax 请求商品属性
	public function getattr(){
		$type_id=I('post.type_id');
		// dump($type_id);
		//参数检测
		if($type_id == intval( $type_id)){
			$attr = D('Attribute') -> where( array('type_id' => $type_id) ) -> select();
			$return =array(
				'code'=>10000,
				'msg' =>'success',
				'attr'=>$attr,
				);
			$this->ajaxReturn($return);
		}else{
			$return =array(
				'code'=>10001,
				'msg' =>'参数错误',
				);
			$this->ajaxReturn($return);
		}
	}	
}