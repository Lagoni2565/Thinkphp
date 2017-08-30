<?php 
namespace Home\Controller;
use Think\Controller;
// use Admin\Model\GoodsModel;
class TestController extends Controller{
    public function test_curl(){
        //测试，获取购物车购买总数 
        // URL组装 支持不同URL模式 U函数
        //  * @param string $url URL表达式，格式：'[模块/控制器/操作#锚点@域名]?参数1=值1&参数2=值2...'
        //  * @param string|array $vars 传入的参数，支持数组和字符串
        //  * @param string|boolean $suffix 伪静态后缀，默认为true表示获取配置值 html
        //  * @param boolean $domain 是否显示域名
        //  * @return string
        $url = U('Home/Cart/ajaxgetnum','','',true);
        dump($url);//请求地址
        //发送post请求
        $res = curl_request($url,true);
        dump($res);
    }
    public function kuaidi(){
        $data=I('get.kuaidi');
        //本次测试 由于没有表单进行提交 故把数据写死啦
        // 使用get 请求
        //$type 为快递公司 代码 
        $type='yunda';
        //运单号
        $postid="3101314976598";
        //请求地址
        $url="https://www.kuaidi100.com/query?type={$type}&postid={$postid}";
        //调用 我们写好的curl_request(); 发送请求
        $result=curl_request($url,'','',true);
        //判断请求成功与否
          if ($result == false) {
            $this->error('请求失败');
            // echo "请求失败",die;
        }
        //将返回的数据解析成数组
        $res_arr=json_decode($result,true);
        // dump($res_arr);
        //判断 返回数据状态
        if ($res_arr['status'] != 200 ) {
           echo " 查询失败";die;
        }

        //分析数据 直接显示在页面上
        echo "运单走单进度<br>";
        foreach ($res_arr['data'] as $k => $v) {
            if ($k == 0) {
                echo "<p style='color:red'>".$v['time'].'-----------'.$v['location']."</p>";
            }else{
                echo $v['time'].'-----------'.$v['location']."<br>";
            }
         
        }

    }

    //百度地图 静态图使用
    public function jingtaitu(){
        layout(false);
        $url="http://api.map.baidu.com/staticimage/v2?ak=LT9f8e73aYsx3G3D1mCRXlSUgw3hDZrn&center=113.66724,34.752021&width=1000&height=800&zoom=16";
        $this->assign('url',$url);
              $this->display();
    }

    //百度动态地图
    public function dongtaiditu(){
        // http://api.map.baidu.com/marker?location=40.047669,116.313082&title=我的位置&content=百度奎科大厦&output=html&src=yourComponyName|yourAppName    //调起百度PC或web地图，且在（lat:39.916979519873，lng:116.41004950566）坐标点上显示名称"我的位置"，内容"百度奎科大厦"的信息窗口。
        layout(false);
        $location='33.802171,115.440369';
        $title="我家";
        $content="家";
        $output='html';
        $src="biubiu";
        $zoom=18;
        $url="http://api.map.baidu.com/marker?location={$location}&title={$title}&content={$content}&output=html&src={$src}$zoom={$zoom}";
        $this->assign('url',$url);
        $this->display();
    }

    //发送邮件
    public function test_email()
    {
        $email = "agoni2565@163.com";
        $subject = "使用PHPMailer发送测试邮件";
        $body = "使用PHPMailer发送测试邮件内容部分";
        $res = sendmail($email,$subject,$body);
        if ($res === true) {
           echo 'success';
        }else{
             echo $res;
        }
    }
    
}