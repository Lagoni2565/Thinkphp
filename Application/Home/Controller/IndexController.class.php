<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {
	//首页
    public function index(){
      
      // echo date("Y-m-d H:i:s",strtotime('-1 day',time()));
      // 输出前一天的时间
      // die;
        $title="tpshop商城首页";
        $this->assign('title',$title);
        //获取所有商品分类
        $category=M('Category')->select();
        $this->assign('category',$category);

        
        //要显示商品分类id 为 20 的商品
        $cate_20 =M('Goods')->where('cate_id=20')->limit(12)->select();
        $this->assign('cate_20',$cate_20);
        $category_name20= M('Category') -> find(20);
        // dump($categroy_name1);die; 
        $this->assign('category_name20',$category_name20);

        //要显示商品分类id 为 18 的商品
        $cate_18 =M('Goods')->where('cate_id=18')->limit(12)->select();
        $this->assign('cate_18',$cate_18);
        $category_name18= M('Category') -> find(18);
        // dump($categroy_name1);die; 
        $this->assign('category_name18',$category_name18);

        //要显示商品分类id 为 1 的商品
        $cate_1 =M('Goods')->where('cate_id=1')->limit(12)->select();
        $this->assign('cate_1',$cate_1);
        $category_name1= M('Category') -> find(1);
        // dump($categroy_name1);die; 
        $this->assign('category_name1',$category_name1);

        $this->display();
    }

    //商品详情页
    public function detail(){
        $this->assign('title','商品详情页');
        //获取查询数据的id
        $id=I('get.id'); 
        //文件名称
        $file = "./Static/detail_{$id}.html";
        //判断文件是否存在 若存在則直接訪問靜態文件 )
        if (file_exists($file) && (time() - filemtime($file)) < 300) {
            redirect("/Static/detail_{$id}.html");
        }

        //查询商品基本信息
        $goods=D('Goods')->find($id);
        $this->assign('goods',$goods);

        //查询商品的单一属性和唯一属性
        $attr=D('Attribute') ->where(array('type_id'=>$goods['type_id']))->select();
        // dump($attr);die;
        $goods_attr=D('GoodsAttr')->where( array('goods_id'=>$id) )->select();

        //获取商品所有图片
        $goods_pics= D('Goodspics')-> where(array('goods_id'=>$id) )->select();
        $this->assign('goods_pics',$goods_pics);

        $this->assign('attr',$attr);
        $this->assign('goods_attr',$goods_attr);
     //    //开启ob缓存 
        ob_start();
     //    //输出一些内容
    	$this->display();
     //    //从ob缓存中获取其中的内容
     //    $str = ob_get_contents();
        $str = ob_get_clean();
     //    //把获取的内容放入一个文件内
     //    $file ="./Static/detial_{$id}.html";
     //    if (file_exists($file)) {
     //       redirect("/Static/detial_{$id}.html");
     //    }
     //    file_put_contents($file, $str);
     //    //跳转 调用函数库里封装的 redirect()函数
     //    redirect("/Static/detail_{$id}.html");   
     //使用fetch 方法获取页面内容
        // $str =  $this->fetch();  
        
        $file = "./Static/detail_{$id}.html";
        // dump($str);
        // dump($file);die;
        file_put_contents($file,$str);
          // die;
     //跳转  
        redirect("/Static/detail_{$id}.html");  
    }
}

