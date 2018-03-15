@extends('layouts.home')
@section('info')
<title>{{Config::get('web.web_title')}}-{{Config::get('web.seo_title')}}</title>
<meta name="keywords" content="{{Config::get('web.keywords')}}" />
<meta name="description" content="{{Config::get('web.description')}}" />
<link href="{{asset('css/index.css')}}" rel="stylesheet">
@endsection
@section('content')
<div class="banner">
			  <section class="box clearfix">
			    {!!Config::get('web.saying')!!}
			    <div class="introduction">
			    	{!!Config::get('web.myIntro')!!}
			    </div>
			    <div class="avatar"><a href="{{url('/')}}"><span>止戈</span></a> </div>
			  </section>
			</div>
		</header>
		<!-- E = 头部 -->
		<!-- S = 主体部分 -->
		<div class="main clearfix">
			<h2 class="title_tj">
		    <p>文章<span>推荐</span></p>
		  </h2>
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