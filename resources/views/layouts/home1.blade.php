<!doctype html>
<html>
<head>
<meta charset="utf-8">
@yield('info')
<link href="{{asset('resources/views/home/css/base.css')}}" rel="stylesheet">
<!--[if lt IE 9]>
<script src="{{asset('resources/views/home/js/modernizr.js')}}"></script>
<![endif]-->
</head>
<body>
<header>
  <h1 id="logo"><a href="/">止戈个人博客</a></h1>
  <nav class="topnav" id="topnav">
    @foreach($navs as $v)
    <a href="{{$v['nav_url']}}"><span>{{$v['nav_name']}}</span><span class="en">{{$v['nav_alias']}}</span></a>
    @endforeach
  </nav>
</header>
@section('content')
 <!-- Baidu Button BEGIN -->
<div class="bdsharebuttonbox"><a href="#" class="bds_more" data-cmd="more"></a><a href="#" class="bds_qzone" data-cmd="qzone" title="分享到QQ空间"></a><a href="#" class="bds_tsina" data-cmd="tsina" title="分享到新浪微博"></a><a href="#" class="bds_tqq" data-cmd="tqq" title="分享到腾讯微博"></a><a href="#" class="bds_renren" data-cmd="renren" title="分享到人人网"></a><a href="#" class="bds_weixin" data-cmd="weixin" title="分享到微信"></a></div>
<script>window._bd_share_config={"common":{"bdSnsKey":{},"bdText":"","bdMini":"2","bdMiniList":false,"bdPic":"","bdStyle":"0","bdSize":"32"},"share":{}};with(document)0[(getElementsByTagName('head')[0]||body).appendChild(createElement('script')).src='http://bdimg.share.baidu.com/static/api/js/share.js?v=89860593.js?cdnversion='+~(-new Date()/36e5)];</script>
    <!-- Baidu Button END -->
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
@show
<footer>
  <p>{!!Config::get('web.copyright')!!} {!!Config::get('web.web_count')!!} </p>
</footer>
<script src="{{asset('resources/views/home/js/silder.js')}}"></script>
</body>
</html>
