<!DOCTYPE html>
<html lang="zh-CN">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<title>{{$field->art_title}}-{{Config::get('web.web_title')}}</title>
	<meta name="keywords" content="{{$field->art_tag}}" />
	<meta name="description" content="{{$field->art_description}}" />
	<link href="{{asset('css/new.css')}}" rel="stylesheet">
	<script src="{{asset('js/jquery.min.js')}}"></script>
	<meta name="viewport" content="width=device-width,initial-scale=1">
	<link rel="stylesheet" href="{{asset('css/normalize.css')}}">
	<link rel="stylesheet" href="{{asset('org/ueditor/third-party/SyntaxHighlighter/shCoreDefault.css')}}">
	<script type="text/javascript" src="{{asset('org/ueditor/third-party/SyntaxHighlighter/shCore.js')}}"></script>
<script>$(function(){SyntaxHighlighter.highlight(),$("table.syntaxhighlighter").each(function(){if(!$(this).hasClass("nogutter")){var h=$($(this).find(".gutter")[0]),i=$($(this).find(".code .line"));h.find(".line").each(function(h){$(this).height($(i[h]).height()),$(i[h]).height($(i[h]).height())})}})});</script>
</head>
<body>
	<div class="container">
		<!--[if lte IE 8]>
		<p class="browserupdate">你的浏览器版本太低，请到<a href="http://browsehappy.com">这里</a>下载最新版本以提升浏览体验</p>
		<![endif]-->
		<!-- S = 头部 -->
		<header>
			<nav class="top-nav">
				<MARQUEE scrollAmount=4 direction=left>{{Config::get('web.web_notice')}}</MARQUEE>
				<ul>
					@if(!isset($mem))
					<li><a href="{{url('/login')}}">登录</a></li>
					<li><a href="{{url('/register')}}">注册</a></li>
					@else
					<li>你好,{{$mem->username}}!</li>
					@endif
					<li><a href="{{url('/n/' . Config::get('web.about'))}}">关于</a></li>
				</ul>
			</nav>
			<nav class="main-nav clearfix">
				<h1 class="logo">
					<span class="text-hide">止戈个人博客</span>
					<a href="{{url('/')}}"><img src="{{url('images/blog_log.png')}}" alt="止戈个人博客logo"></a>
				</h1>
				<nav class="topnav" id="topnav">
					<ul>
						@foreach($navs as $v)
						<li><a href="{{$v['nav_url']}}">{{$v['nav_name']}}</a></li>
					    @endforeach
						<li><a href="#category"></a></li>
					</ul>
				</nav>
			</nav>
			</header>
		<!-- E = 头部 -->
		<!-- S = 内容部分 -->
		<div class="main clearfix">
			<h3 class="t_nav"><span>您当前的位置：<a href="{{url('/')}}">首页</a>&nbsp;&gt;&nbsp;<a href="{{url('n/' . $field->art_id)}}">{{$field->art_title}}</a></span><a href="{{url('/')}}" class="n1">回到首页</a><a href="{{url('n/' . $field->art_id)}}" class="n2">{{$field->art_title}}</a></h3>
			<article class="index_about">
			    <h2 class="c_titile">{{$field->art_title}}</h2>
			    <p class="box_c"><span class="d_time">发布时间：{{date('Y-m-d',$field->art_time)}}</span><span>编辑：{{$field->art_editor}}</span><span>查看次数：{{$field->art_view}}</span></p>
			    <div class="infos">
			      {!!$field->art_content!!}
			    </div>
			    <div class="ad"> </div>
			    
			    
			</article>
			<div class="aside-info">
				<aside class="aside-intro clearfix">
					<div class="avatar"><a href="{{url('/')}}"><span>止戈</span></a> </div>
					<div class="introduction">
				    	{!!Config::get('web.myIntro')!!}
				    </div>   
				</aside>
				<aside class="clearfix">
					    <span class="a-share">分享: </span><!-- Baidu Button BEGIN -->
					    <div id="bdshare" class="bdshare_t bds_tools_32 get-codes-bdshare"><a class="bds_tsina"></a><a class="bds_qzone"></a><a class="bds_tqq"></a><a class="bds_renren"></a><span class="bds_more"></span><a class="shareCount"></a></div>
					    <script type="text/javascript" id="bdshare_js" data="type=tools&amp;uid=6574585" ></script> 
					    <script type="text/javascript" id="bdshell_js"></script> 
					    <script type="text/javascript">
					document.getElementById("bdshell_js").src = "http://bdimg.share.baidu.com/static/js/shell_v2.js?cdnversion=" + Math.ceil(new Date()/3600000)
					</script> 
					    <!-- Baidu Button END --> 
				</aside>
				<aside  id="category">
					<h3>
				      <p>文章<span>分类</span></p>
				    </h3>
				    <ul class="rank">
				    	@foreach($cates as $c)
				       	<li>{{str_repeat('&nbsp;&nbsp;&nbsp;',$c['lev'])}}<a href="{{url('/cate/' . $c->cate_id)}}" title="{{$c->cate_name}}" target="_blank">{{$c->cate_name}}&nbsp;(<span>{{$c->cate_count}}</span>)</a></li>
				      	@endforeach
				    </ul>
				</aside>
				<aside>
					<h3 class="ph">
				      <p>点击<span>排行</span></p>
				    </h3>
				    <ul class="paih">
				      @foreach($point as $p)
				      <li><a href="{{url('a/' . $p->art_id)}}" title="{{$p->art_title}}" target="_blank">{{$p->art_title}}</a></li>
				      @endforeach
				    </ul>
				</aside>
				<aside>
				    <h3 class="links">
				      <p>友情<span>链接</span></p>
				    </h3>
				    <ul class="website">
				      @foreach($links as $l)
					      <li><a href="{{url($l->link_url)}}" title="{{$l->link_name}}" target="_blank">{{$l->link_name}}</a></li>
					     @endforeach
				    </ul>
				</aside>
			</div>
		</div>
		<!-- E = 主体部分 -->
		<!-- S = 尾部 -->
		<footer>
		  <p>{!!Config::get('web.copyright')!!} {!!Config::get('web.web_count')!!} </p>
		</footer>
		<!-- E = 尾部 -->
	</div>
	{!!Config::get('web.count')!!}
</body>
</html>