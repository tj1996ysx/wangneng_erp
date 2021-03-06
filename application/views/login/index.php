
<!DOCTYPE html>
<html lang="zh">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" />
	<title>登录页面</title>
	<link rel="icon" href="favicon.ico" type="image/ico">
	<meta name="author" content="yinqi">
	<link href="/static/css/bootstrap.min.css" rel="stylesheet">
	<link href="/static/css/materialdesignicons.min.css" rel="stylesheet">
	<link href="/static/css/style.min.css" rel="stylesheet">
	<link rel="stylesheet" href="/static/extend/css/layui.css" media="all">
	<script src="/static/extend/layui.js" charset="utf-8"></script>
	<script type="text/javascript" src="/static/js/jquery.min.js"></script>

	<script type="text/javascript" src="/static/layer/layer/layer.js"></script>
	<style>
		.lyear-wrapper {
			position: relative;
		}
		.lyear-login {
			display: flex !important;
			min-height: 70vh;
			align-items: center !important;
			justify-content: center !important;
		}
		.login-center {
			background: #fff;
			min-width: 38.25rem;
			padding: 2.14286em 3.57143em;
			border-radius: 5px;
			margin: 2.85714em 0;
		}
		.login-header {
			margin-bottom: 1.5rem !important;
		}
		.login-center .has-feedback.feedback-left .form-control {
			padding-left: 38px;
			padding-right: 12px;
		}
		.login-center .has-feedback.feedback-left .form-control-feedback {
			left: 0;
			right: auto;
			width: 38px;
			height: 38px;
			line-height: 38px;
			z-index: 4;
			color: #dcdcdc;
		}
		.login-center .has-feedback.feedback-left.row .form-control-feedback {
			left: 15px;
		}
	</style>

</head>

<body onkeydown="keyLogin();">
<div class="row lyear-wrapper">
	<div class="lyear-login">
		<div class="login-center">
			<div class="login-header text-center">
				<h3>官网后台管理</h3>
			</div>
 		<form  >
				<div class="form-group has-feedback feedback-left">
					<input type="text" placeholder="请输入您的用户名" class="form-control" name="username" id="username" required minlength="1" />
					<span class="mdi mdi-account form-control-feedback" aria-hidden="true"></span>
				</div>
				<div class="form-group has-feedback feedback-left">
					<input type="password" placeholder="请输入密码" class="form-control" id="password" name="password" required />
					<span class="mdi mdi-lock form-control-feedback" aria-hidden="true"></span>
				</div>
				<div class="form-group has-feedback feedback-left row">
					<div class="col-xs-7">
						<input type="text" id="captcha" name="captcha" class="form-control" placeholder="验证码">
						<span class="mdi mdi-check-all form-control-feedback" aria-hidden="true"></span>
					</div>
					<div class="col-xs-5">
						<img src="/login/captcha" class="pull-right" id="captcha1" style="cursor: pointer;" onclick="this.src=this.src+'?d='+Math.random();" title="点击刷新" alt="captcha">
					</div>
				</div>
				<div class="form-group">
					<button  class="btn btn-block btn-primary" type="button" id="login">立即登录</button>
				</div>
 		</form>
			<hr>
			<footer class="col-sm-12 text-center">

			</footer>
		</div>
	</div>
</div>
<script type="text/javascript" src="/static/js/jquery.min.js"></script>
<script type="text/javascript" src="/static/js/bootstrap.min.js"></script>
<script>
	$('#login').on('click', function() {

		var param = {};
		param.username = $('#username').val();
		param.password = $('#password').val();
		param.captcha = $('#captcha').val();
		//alert(param.password)
		$.ajax({
			type: "POST",
			url: '<?php echo base_url("/login"); ?>',
			dataType: "json",
			async: false,
			data: param,
			success: function(data) {
				if (data.code == 0) {
					layer.msg(data.msg, {
						icon: 1,
						time: 2000 //2秒关闭（如果不配置，默认是3秒）
					}, function() {
						location.href='/';
					});

				} else {
					layer.msg(data.msg, {
						icon: 2,
						time: 2000 //2秒关闭（如果不配置，默认是3秒）
					});
					$('#captcha1').attr('src', '/login/captcha');
				 
				}
			}
		});
	});
	function keyLogin(){
	 	if (event.keyCode==13)  //回车键的键值为13
	   		document.getElementById("login").click(); //调用登录按钮的登录事件
	}
</script>
</body>
</html>
