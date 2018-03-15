@extends('layouts.home')
@section('info')
<title>{{$cateinfo->cate_name}}-{{Config::get('web.web_title')}}</title>
<meta name="keywords" content="{{$cateinfo->cate_keywords}}" />
<meta name="description" content="{{$cateinfo->cate_description}}" />
<link href="{{asset('css/list.css')}}" rel="stylesheet">
@endsection
@section('content')
</header>
		<!-- E = 头部 -->
		<!-- S = 主要内容 -->
		<div class="main">
			<h3 class="t_nav"><span class="nav-intro">{{$cateinfo->cate_title}}</span><a href="{{url('/')}}" class="n1">回到首页</a><a href="{{url('cate/' . $cateinfo->cate_id)}}" class="n2">{{$cateinfo->cate_name}}</a></h3>
			<article class="bloglist">
		  	@foreach($data as $d)
		  	<div class="bloglist-item clearfix">
			    <h3><a title="{{$d->art_title}}" href="{{url('a/' . $d->art_id)}}" target="_blank">{{$d->art_title}}</a></h3>
			    <figure><a title="{{$d->art_title}}" href="{{url('a/' . $d->art_id)}}" target="_blank"><img src="{{url($d->art_thumb)}}"></a></figure>
			    <ul>
			      <p>{{$d->art_description}}</p>
			      <a title="{{$d->art_title}}" href="{{url('a/' . $d->art_id)}}" target="_blank" class="readmore">阅读全文>></a>
			    </ul>
			    <p class="dateview"><span>作者：{{$d->art_editor}} 在</span><span>{{date('Y-m-d',$d->art_time)}}</span><span>发布在：[<a href="{{url('cate/' . $d->cate_id)}}">{{$d->cate_name}}</a>]</span><span>评论&nbsp;{{$d->art_comment}}&nbsp;次</span><span>阅读&nbsp;{{$d->art_view}}&nbsp;次</span></p>
		    </div>
		    @endforeach
		    <div class="page_list">
     			 {{$data->links()}}
    		</div>
		  </article>
		  @parent
@endsection