<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
  <head>
	<meta charset="utf-8">
    <title>登录</title>
    <link rel="stylesheet" type="text/css" href="/Public/Admin/css/login.css">
    <style type="text/css">
        .login-bg{
            background: url(/Public/Admin/img/login-bg-4.jpg) no-repeat center center fixed;
            background-size: 100% 100%;
        }
    </style>
  </head>
  
  <body class="login-bg">
    <div class="login-box">
        <header>
            <h1>后台管理系统</h1>
        </header>
        <div class="login-main">
			<form action="/index.php/Admin/Login/login.html" class="form" method="post">          
				<div class="form-item">
					<label class="login-icon">
						<i></i>
					</label>
					<input type="text" id='username' name="username" placeholder="这里输入登录名" required>
				</div>
                <div class="form-item">
                    <label class="login-icon">
                        <i></i>
                    </label>
                    <input type="password" id="password" name="password" placeholder="这里输入密码">
                </div>
                <div class="form-item verify">
                    <label class="login-icon">
                        <i></i>
                    </label>
                    <input type="text" id='verify' class="pull-left" name="verify" placeholder="这里输入验证码">
                    <img class="pull-right" src="/index.php/Admin/Login/captcha" onclick="this.src='/index.php/Admin/Login/captcha/_/'+Math.random()">
                    <div class="clear"></div>
                </div>
				<div class="form-item">
					<button type="button" class="login-btn">
						登&emsp;&emsp;录
					</button>
				</div>
			</form>
            <div class="msg"></div>
		</div>
    </div>
    <script type="text/javascript" src='/Public/Admin/js/jquery-3.1.1.min.js'></script>
    <script type="text/javascript">
        $(function(){
            $('.login-btn').on('click',function(){
                if($('#username').val() == ''){
                    $('.msg').html('登录名不能为空');
                    return;
                }
                if($('#password').val() == ''){
                    $('.msg').html('密码不能为空');
                    return;
                }
                if($('#verify').val() == ''){
                    $('.msg').html('验证码不能为空');
                    return;
                }
                // $('form').submit();
                // 
               // 使用Ajax 提交表单
               //获取登录表单输入的值
               var data = {
                'username':$('#username').val(),
                'password':$('#password').val(),
                'code':$('#verify').val(),
               }
                
               //发送 Ajax 请求
               $.ajax({
                    'url':'/index.php/Admin/Login/ajaxlogin',
                    'type':'post',
                    'data':data,
                    'dataType':'json',
                    'success':function(response){
                        console.log(response);
                        //处理数据 code = 10000代表成功，其他都是失败
                        if(response.code != 10000){
                            alert(response.msg);
                        }else{
                            //成功，跳转到后台首页
                            location.href = '/index.php/Admin/Index/index';
                        }
                    }
                });
            });
        })
    </script>
  </body>
</html>