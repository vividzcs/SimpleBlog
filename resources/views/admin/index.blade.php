@extends('layouts.admin')

@section('content')
<body>
	<!--头部 开始-->
	<div class="top_box">
		<div class="top_left">
			<div class="logo">止戈个人博客</div>
			<ul>
				<li><a href="{{url('/')}}" target="_blank" class="active">首页</a></li>
				<li><a href="{{url('admin/info')}}" target="main">管理页</a></li>
			</ul>
		</div>
		<div class="top_right">
			<ul>
				@if(session('user'))
				<li>管理员：{{session('user')['username']}}</li>
				@endif
				<li><a href="{{url('admin/pass')}}" target="main">修改密码</a></li>
				<li><a href="{{url('admin/quit')}}">退出</a></li>
			</ul>
		</div>
	</div>
	<!--头部 结束-->

	<!--左侧导航 开始-->
	<div class="menu_box">
		<ul>
            <li>
            	<h3><i class="fa fa-fw fa-clipboard"></i>常用操作</h3>
                <ul class="sub_menu">
                    <li><a href="{{url('admin/category/create')}}" target="main"><i class="fa fa-fw fa-plus-square"></i>添加栏目</a></li>
                    <li><a href="{{url('admin/category')}}" target="main"><i class="fa fa-fw fa-list-ul"></i>栏目列表</a></li>
                	<li><a href="{{url('admin/article/create')}}" target="main"><i class="fa fa-fw fa-plus-square"></i>添加文章</a></li>
                    <li><a href="{{url('admin/article')}}" target="main"><i class="fa fa-fw fa-list-ul"></i>文章列表</a></li>
                    <li><a href="{{url('admin/comment')}}" target="main"><i class="fa fa-fw fa-comment"></i>评论列表</a></li>
                    <li><a href="{{url('admin/notice/create')}}" target="main"><i class="fa fa-fw fa-plus-square"></i>添加系统文章</a></li>
                    <li><a href="{{url('admin/notice')}}" target="main"><i class="fa fa-fw fa-list-ul"></i>系统文章列表</a></li>
                    <li><a href="{{url('admin/member')}}" target="main"><i class="fa fa-fw fa-list-ul"></i>会员列表</a></li>
                </ul>
            </li>
            <li>
            	<h3><i class="fa fa-fw fa-cog"></i>系统设置</h3>
                <ul class="sub_menu" style="display:block;">
                    <li><a href="{{url('admin/links')}}" target="main"><i class="fa fa-fw fa-cubes"></i>友情链接</a></li>
                    <li><a href="{{url('admin/navs')}}" target="main"><i class="fa fa-fw fa-navicon"></i>自定义导航</a></li>
                    <li><a href="{{url('admin/config')}}" target="main"><i class="fa fa-fw fa-cogs"></i>网站配置</a></li>
                </ul>
            </li>
            
        </ul>
	</div>
	<!--左侧导航 结束-->

	<!--主体部分 开始-->
	<div class="main_box">
		<iframe src="{{url('admin/info')}}" frameborder="0" width="100%" height="100%" name="main"></iframe> 
	</div>
	<!--主体部分 结束-->

	<!--底部 开始-->
	<div class="bottom_box">
		CopyRight © 2017. Powered By <a href="http://www.ilearnspace.cn">http://www.ilearnspace.cn</a>.
	</div>
	<!--底部 结束-->
@endsection