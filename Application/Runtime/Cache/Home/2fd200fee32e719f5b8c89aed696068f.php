<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>静态图</title>
</head>
<body>
	百度静态图<br/>
	<img src="<?php echo ($url); ?>">
	<iframe src="<?php echo ($url); ?>" width="800" height="600" frameborder="0" ></iframe>
	<br/>
	<img src="http://api.map.baidu.com/staticimage/v2?ak=LT9f8e73aYsx3G3D1mCRXlSUgw3hDZrn&center=113.66724,34.752021&width=1000&height=800&zoom=16">
</body>
</html>