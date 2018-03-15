@extends('layouts.home')
@section('info')
<title>{{Config::get('web.web_title')}}-{{Config::get('web.seo_title')}}</title>
<meta name="keywords" content="{{Config::get('web.keywords')}}" />
<meta name="description" content="{{Config::get('web.description')}}" />
<link href="{{asset('resources/views/home/css/index.css')}}" rel="stylesheet">
@endsection
@section('content')
<style>
  .page_list{margin-top:15px}
  .page_list ul{overflow:hidden;border:1px solid #ddd;border-radius:3px;padding:0;margin:0;display:inline-block}
  .page_list ul li{float:left;border:none;height:30px;line-height:30px;border-right:1px solid #ddd}
  .page_list ul li a,.page_list ul li span{padding:6px 12px;text-decoration:none}
  .page_list ul li a:hover{background:#eee}
  .page_list ul li.active a{color:#fff;cursor:default;background-color:#337ab7;border-color:#337ab7}
</style>
<div class="banner">
  <section class="box">
    {!!Config::get('web.saying')!!}
    <div class="avatar"><a href="#"><span>止戈</span></a> </div>
  </section>
</div>
<div class="template">
  <div class="box">
    <h3>
      <p><span>热门</span>推荐 Recommend</p>
    </h3>
    <ul>
      @foreach($hot as $h)
      <li><a href="{{url('a/' . $h->art_id)}}"  target="_blank"><img src="{{url($h->art_thumb)}}"></a><span>{{$h->art_description}}</span></li>
      @endforeach
    </ul>
  </div>
</div>
<article>
  <h2 class="title_tj">
    <p>文章<span>推荐</span></p>
  </h2>
  <div class="bloglist left">
    @foreach($data as $d)
    <h3><a title="{{$d->art_title}}" href="{{url('a/' . $d->art_id)}}" target="_blank">{{$d->art_title}}</a></h3>
    <figure><a title="{{$d->art_title}}" href="{{url('a/' . $d->art_id)}}" target="_blank"><img src="{{url($d->art_thumb)}}"></a></figure>
    <ul>
      <p>{{$d->art_description}}</p>
      <a title="{{$d->art_title}}" href="{{url('a/' . $d->art_id)}}" target="_blank" class="readmore">阅读全文>></a>
    </ul>
    <p class="dateview"><span>{{date('Y-m-d',$d->art_time)}}</span><span>作者：{{$d->art_editor}}</span><span>个人博客：[<a href="{{url('cate/' . $d->cate_id)}}">{{$d->cate_name}}</a>]</span></p>
    @endforeach
    <div class="page_list">
        {{$data->links()}}
    </div>
  </div>
  <aside class="right">
    <!-- Baidu Button BEGIN -->
<div class="bdsharebuttonbox"><a href="#" class="bds_more" data-cmd="more"></a><a href="#" class="bds_qzone" data-cmd="qzone" title="分享到QQ空间"></a><a href="#" class="bds_tsina" data-cmd="tsina" title="分享到新浪微博"></a><a href="#" class="bds_tqq" data-cmd="tqq" title="分享到腾讯微博"></a><a href="#" class="bds_renren" data-cmd="renren" title="分享到人人网"></a><a href="#" class="bds_weixin" data-cmd="weixin" title="分享到微信"></a></div>
<script>window._bd_share_config={"common":{"bdSnsKey":{},"bdText":"","bdMini":"2","bdMiniList":false,"bdPic":"","bdStyle":"0","bdSize":"32"},"share":{}};with(document)0[(getElementsByTagName('head')[0]||body).appendChild(createElement('script')).src='http://bdimg.share.baidu.com/static/api/js/share.js?v=89860593.js?cdnversion='+~(-new Date()/36e5)];</script>
    <!-- Baidu Button END -->
    <div class="news" style="float:left;">
    <h3>
      <p>最新<span>文章</span></p>
    </h3>
    <ul class="rank">
      @foreach($new as $n)
      <li><a href="{{url('a/' . $n->art_id)}}" title="{{$n->art_title}}" target="_blank">{{$n->art_title}}</a></li>
      @endforeach
    </ul>
    <h3 class="ph">
      <p>点击<span>排行</span></p>
    </h3>
    <ul class="paih">
      @foreach($point as $p)
      <li><a href="{{url('a/' . $p->art_id)}}" title="{{$p->art_title}}" target="_blank">{{$p->art_title}}</a></li>
      @endforeach
    </ul>
    <h3 class="links">
      <p>友情<span>链接</span></p>
    </h3>
    <ul class="website">
      @foreach($links as $l)
      <li><a href="{{$l->link_url}}" target="_blank">{{$l->link_name}}</a></li>
      @endforeach
    </ul> 
    </div>  
       
    </aside>
</article>
@endsection