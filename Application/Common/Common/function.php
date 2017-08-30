<?php 
//框架会自动加载 本文件中的自定义 函数
//手机号加密： 15670071911-> 156****1911
function encrypt_phone($phone)
{
	return substr($phone,0,3).'****'.substr($phone,7);
}

//加密函数
function encrypt_password($password)
{
	//加盐
	$salt = 'asdasdas;asddasd';
	return md5($salt.md5($password));
}

//封装一个函数 使用htmlpurifier 插件 对字符串进行过滤
function remove_xss($string)
{
	//相对index.php入口文件，引入HTMLPurifier.auto.php核心文件
    require_once './Public/Admin/htmlpurifier/HTMLPurifier.auto.php';
    // 生成配置对象
    $cfg = HTMLPurifier_Config::createDefault();
    // 以下就是配置：
    $cfg -> set('Core.Encoding', 'UTF-8');
    // 设置允许使用的HTML标签
    $cfg -> set('HTML.Allowed','div,b,strong,i,em,a[href|title],ul,ol,li,br,p[style],span[style],img[width|height|alt|src]');
    // 设置允许出现的CSS样式属性
    $cfg -> set('CSS.AllowedProperties', 'font,font-size,font-weight,font-style,font-family,text-decoration,padding-left,color,background-color,text-align');
    // 设置a标签上是否允许使用target="_blank"
    $cfg -> set('HTML.TargetBlank', TRUE);
    // 使用配置生成过滤用的对象
    $obj = new HTMLPurifier($cfg);
    // 过滤字符串
    return $obj -> purify($string);
}

#递归方法实现无限极分类
function getTree($list,$pid=0,$level=0) 
{
    static $tree = array();
    foreach($list as $row) {
        if($row['pid']==$pid) {
            $row['level'] = $level;
            $tree[] = $row;
            getTree($list, $row['id'], $level + 1);
        }
    }
    return $tree;
}
/*
$url 请求地址
$post=false 请求方式 默认 true->post请求
$data=array() 请求参数
$https=false 默认 http 请求 
 */
function curl_request($url,$post=false,$data=array(),$https=false)
{
    //1.初始化请求
    $ch = curl_init($url);
    //2. 配置curl请求设置 请求方式和请求参数
    //默认为get请求 
    //若是post请求 $post=true;
    if($post){
        //设置请求的方式
        curl_setopt($ch,CURLOPT_POST,true);
        //设置请求的 参数
        curl_setopt($ch,CURLOPT_POSTFIELDS,$data);
    }
    //判断是不是 https 请求
    if ($https) {
        //检测SSL证书 设置为false  默认不进行验证 false 表示终止服务器端进行验证 需要时设置成true
        curl_setopt($ch,CURLOPT_SSL_VERIFYPEER,false);
        //检查服务器的SSL 证书中的公用名是否存在  并且是否与提供的 主机名匹配 false  表示不检测
        //检测SSL中证书和域名 匹配 智力禁用检测
        curl_setopt($ch,CURLOPT_SSL_VERIFYHOST,false);
    }
    //3.发送请求 使用curl_exec() 方法 默认返回值为true 或false 
    //在这里我们需要请求返回的 数据 需要先设置一下 设置为true
    curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
    $result=curl_exec($ch);
    //4.请求结束使用curl_close 函数关闭curl请求 释放资源
    curl_exec($ch);
    //返回请求结果给调用位置
    return $result;
}

/**
*@param $email string 收件人地址  
*@param $subject string 邮件主题  
*@param $subject string  邮件内容 
 */
//封装一个发送邮件的方法
function sendmail($email,$subject,$body)
{
   require './Application/Tools/PHPMailer/PHPMailerAutoload.php';
   $mail = new PHPMailer;
    //$mail->SMTPDebug = 3;                               // Enable verbose debug output
    $mail->isSMTP();                                      // Set mailer to use SMTP
    $mail->Host = 'smtp.163.com';  // Specify main and backup SMTP servers
    $mail->SMTPAuth = true;                               // Enable SMTP authentication
    $mail->Username = 'agoni2565@163.com';                 // SMTP username
    $mail->Password = 'lijinhua123456';                           // SMTP password
    $mail->SMTPSecure = 'TLS';                            // Enable TLS 
    $mail->Port = 25;                                    // TCP port to connect to
    $mail->CharSet = 'UTF-8';                               // 设置字符                               
    $mail->setFrom('agoni2565@163.com');
    $mail->addAddress($email);               // Name is optional
    // $mail->addReplyTo('info@example.com', 'Information');
    // $mail->addCC('cc@example.com');
    // $mail->addBCC('bcc@example.com');

    // $mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
    // $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
    $mail->isHTML(true);                                  // Set email format to HTML
    $mail->Subject = $subject;
    $mail->Body    = $body;
    // $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
    if(!$mail->send()) {
        return $mail->ErrorInfo;
    } else {
        return true;
    }
}