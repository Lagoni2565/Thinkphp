<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2014 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用入口文件
// 一句代码让http跳转https
// if(!isset($_SERVER['HTTPS'])){
//     Header("HTTP/1.1 301 Moved Permanently");
//     header('Location: https://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
// }

// 检测PHP环境
if(version_compare(PHP_VERSION,'5.3.0','<'))  die('require PHP > 5.3.0 !');
// ob_start();
// echo 123;
//设置响应头 字符集
header('content-type:text/html;charset=utf-8');

// 开启调试模式 建议开发阶段开启 部署阶段注释或者设为false
define('APP_DEBUG',True);

// 定义应用目录 
define('APP_PATH','./Application/');

//定义文件上传相关目录常量
//当前项目目录对应的磁盘真是路径 网站根目录
define('WEB_ROOT',__DIR__);
//文件上传保存路径
define('UPLOAD_PATH','/Public/Uploads/');

// 引入ThinkPHP入口文件
require './ThinkPHP/ThinkPHP.php';

// 亲^_^ 后面不需要任何代码了 就是如此简单