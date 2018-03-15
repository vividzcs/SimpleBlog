<!DOCTYPE html>
<html lang="zh-CN">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<title>止戈个人博客</title>
	<meta name="viewport" content="width=device-width,initial-scale=1">
	<link rel="stylesheet" href="{{asset('css/normalize.css')}}">
	<link rel="stylesheet" href="{{asset('css/login.css')}}">
</head>
<body>
	<div class="container">
		<!--[if lte IE 8]>
		<p class="browserupdate">你的浏览器版本太低，请到<a href="http://browsehappy.com">这里</a>下载最新版本以提升浏览体验</p>
		<![endif]-->
		<table id="form">
				<tr><td><h1 id="logo">止戈个人博客</h1></td></tr>
				<tr><td><h2>注册止戈个人博客</h2></td></tr>
				<tr><td><input placeholder="Username (必填)" name="username" id="username" type="text" value=""></td></tr>
				<tr><td><input placeholder="Email (必填)" name="email" id="email" type="text" value=""></td></tr>
				<tr><td><input type="password" placeholder="Password (必填)" name="password" id="password" value=""></td></tr>
				<div id="warning"></div>
				<tr><td><button id="register">REGISTER</button></td></tr>
				<tr><td><a href="{{url('login')}}">已有账号?登录-></a></td></tr>	
			</table>
	</div>
	<footer><p><a href="{{url('/')}}">返回首页</a> &nbsp;{!!Config::get('web.copyright')!!} {!!Config::get('web.web_count')!!} </p></footer>
	<script src="{{asset('js/jquery.min.js')}}"></script>
	<script type="text/javascript" src="{{asset('org/layer/layer.js')}}"></script>
	<script src="{{asset('js/register.js')}}"></script>
<script>
$("#register").click(function(){var e=$("#username").val(),a=$("#email").val(),s=$("#password").val();if(!/.{2,8}/.test(e))return void layer.msg("用户名必须为2-8个字符!",{icon:5});if(!/^[0-9a-zA-Z]+@[0-9a-zA-Z]+\.[a-z]{2,5}$/.test(a))return void layer.msg("邮箱格式不正确!",{icon:5});if(!/.{6,}/.test(s))return void layer.msg("密码长度必须大于6位!",{icon:5});var r={username:e,email:a,password:s,_token:"{{csrf_token()}}"};$.ajax({url:"{{url('/member/register')}}",type:"post",data:r,dataType:"json",success:function(e){0==e.status?layer.msg(e.msg,{icon:5}):layer.msg(e.msg,{icon:6})}})});
</script>
@if(isset($rdata))
<script type="text/javascript">
	var data = {!!$rdata!!};if(data.status == 0) {layer.msg(data.msg,{icon:5});}else{layer.msg(data.msg,{icon:6});$(window).attr('location',"{{url('/')}}");}
</script>
@endif
{!!Config::get('web.count')!!}
</body>
</html>