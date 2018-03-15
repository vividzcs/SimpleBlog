@extends('layouts.home')
@section('info')
<title>{{$cateinfo->cate_name}}-{{Config::get('web.web_title')}}</title>
<meta name="keywords" content="{{$cateinfo->cate_keywords}}" />
<meta name="description" content="{{$cateinfo->cate_description}}" />
<link href="{{asset('resources/views/home/css/style.css')}}" rel="stylesheet">
@endsection
@section('content')
<article class="blogs">
<h1 class="t_nav"><span>{{$cateinfo->cate_title}}</span><a href="{{url('/')}}" class="n1">网站首页</a><a href="{{url('cate/' . $cateinfo->cate_id)}}" class="n2">{{$cateinfo->cate_name}}</a></h1>
<div class="newblog left">
  @foreach($data as $d)
   <h2>{{$d->art_title}}</h2>
   <p class="dateview"><span>发布时间：{{date('Y-m-d',$d->art_time)}}</span><span>作者：{{$d->art_editor}}</span><span>分类：[<a href="{{url('cate/' . $d->cate_id)}}">{{$d->cate_name}}</a>]</span></p>
    <figure><img src="{{url($d->art_thumb)}}"></figure>
    <ul class="nlist">
      <p>{{$d->art_description}}</p>
      <a title="{{$d->art_title}}" href="{{url('a/' . $d->art_id)}}" target="_blank" class="readmore">阅读全文>></a>
    </ul>
    <div class="line"></div>
  @endforeach
    <div class="page">
      {{$data->links()}}
    </div>
</div>
<aside class="right">
  @if($submenu)
   <div class="rnav">
      <ul>
        @foreach($submenu as $s)
       <li class="rnav{{mt_rand(1,4)}}"><a href="{{url('cate/' . $s->cate_id)}}" target="_blank">{{$s->cate_name}}</a></li>
       @endforeach
     </ul>      
    </div>
    @endif
<div class="news">
@parent
    </div>
    <div class="visitors">
      <h3><p>最近访客</p></h3>
      <ul>

      </ul>
    </div>
       
</aside>
</article>
@endsection