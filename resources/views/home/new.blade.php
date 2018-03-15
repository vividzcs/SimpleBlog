@extends('layouts.home')
@section('info')
<title>{{$field->art_title}}-{{Config::get('web.web_title')}}</title>
<meta name="keywords" content="{{$field->art_tag}}" />
<meta name="description" content="{{$field->art_description}}" />
<link href="{{asset('css/new.css')}}" rel="stylesheet">
<link rel="stylesheet" href="{{asset('org/ueditor/third-party/SyntaxHighlighter/shCoreDefault.css')}}">
<script src="{{asset('js/jquery.min.js')}}"></script>
<script type="text/javascript" src="{{asset('org/layer/layer.js')}}"></script>
<script type="text/javascript" src="{{asset('js/apply.js')}}"></script>
<script type="text/javascript" src="{{asset('org/ueditor/third-party/SyntaxHighlighter/shCore.js')}}"></script>
<script>
$(function(){SyntaxHighlighter.highlight(),$("table.syntaxhighlighter").each(function(){if(!$(this).hasClass("nogutter")){var h=$($(this).find(".gutter")[0]),i=$($(this).find(".code .line"));h.find(".line").each(function(h){$(this).height($(i[h]).height()),$(i[h]).height($(i[h]).height())})}})});

</script>
@endsection
@section('content')
</header>
		<!-- E = 头部 -->
		<!-- S = 内容部分 -->
		<div class="main clearfix">
			<h3 class="t_nav"><span>您当前的位置：<a href="{{url('/')}}">首页</a>@foreach($par as $pa)&nbsp;&gt;&nbsp;<a href="{{url('cate/' . $pa->cate_id)}}">{{$pa->cate_name}}</a>@endforeach</span><a href="{{url('/')}}" class="n1">回到首页</a><a href="{{url('cate/' . $field->cate_id)}}" class="n2">{{$field->cate_name}}</a></h3>
			<article class="index_about">
			    <h2 class="c_titile">{{$field->art_title}}</h2>
			    <p class="box_c"><span class="d_time">发布时间：{{date('Y-m-d',$field->art_time)}}</span><span>编辑：{{$field->art_editor}}</span><span>查看次数：{{$field->art_view}}</span></p>
			    <div class="infos">
			      {!!$field->art_content!!}
			    </div>
			    <div class="keybq">
			    <p><span>关键字词</span>：{{$field->art_tag}}</p>
			    </div>
			    <div class="ad"> </div>
			    <div class="nextinfo">
			      @if($article['pre'])
			      <p>上一篇：<a href="{{url('a/' . $article['pre']->art_id)}}">{{$article['pre']->art_title}}</a></p>
			      @else
			      <p>上一篇：<span>没有上一篇</span></p>
			      @endif
			      @if($article['next'])
			      <p>上一篇：<a href="{{url('a/' . $article['next']->art_id)}}">{{$article['next']->art_title}}</a></p>
			      @else
			      <p>上一篇：<span>没有上一篇</span></p>
			      @endif
			    </div>
			    <div class="otherlink">
			      <h2>相关文章</h2>
			      <ul>
			        @foreach($data as $d)
			        <li><a href="{{url('a/' . $d->art_id)}}" title="{{$d->art_title}}">{{$d->art_title}}</a></li>
			        @endforeach
			      </ul>
			    </div>
			    <h2 class="comment-area">评论</h2>
			    <div id="respond" class="comment-respond">
	                <h3>发表评论</h3>
	                <a href="javascript:" style="display:none;color:#66CC9A;" onclick="cancil();">点击这里取消评论</a>
	                <form action="javascript::" method="post" id="com">
	                    @if(!isset($mem))
						<p>
	                    <input placeholder="昵称 (必填)" name="nick" type="text" value="" size="30">
	                    </p>
	                    <p>
	                    <input placeholder="Email (必填)" name="email" type="text" value="" size="30">
	                    </p>
						@else
						<p>
	                    <input placeholder="昵称 (必填)" name="nick" type="hidden" value="{{$mem->email}}" size="30">
	                    </p>
	                    <p>
	                    <input placeholder="Email (必填)" name="email" type="hidden" value="{{$mem->username}}" size="30">
	                    </p>
						@endif

	                    <p>
	                    <textarea name="content" cols="45" rows="8" aria-required="true"></textarea>
	                    <p>
	                    <input id="postCom" type="button" value="发表留言">
	                </p>
	                </form>
            	</div>
			  <div id="comments">
			  	@forelse($coms as $c)
                     <ol class="clearfix">
                    <li>
                        <img src="{{asset('images/unknow.jpg')}}" alt="">
                        <cite><a href="#">{{$c[0]->nick}}&nbsp;说：</a></cite> <br>
                        <time>{{date('Y年m月d日 H时i分',$c[0]->pubtime)}}</time>
                    </li>
                    <li class="comContent">
                        {{$c[0]->content}}
                    </li>
                    <li><a href="#respond" onclick="apply({{$c[0]->comment_id}},{{$c[0]->reply_to}},'{{$c[0]->nick}}','{{$c[0]->nick}}');">回复</a></li>
                    	@if(isset($c[1]))
                    	@foreach($c[1] as $cb)
                    	<ol class="clearfix" style="margin-left: 3rem;">
		                    <li>
		                        <img src="{{asset('images/unknow.jpg')}}" alt="">
		                        <cite><a href="#">{{$cb->nick}}&nbsp;回复&nbsp;{{$cb->reply_to_name}}&nbsp;说：</a></cite> <br>
		                        <time>{{date('Y年m月d日 H时i分',$cb->pubtime)}}</time>
		                    </li>
		                    <li class="comContent">
		                        {{$cb->content}}
		                    </li>
		                    <li><a href="#respond" onclick="apply({{$c[0]->comment_id}},{{$cb->reply_to}},'{{$cb->nick}}','{{$cb->nick}}');">回复</a></li>
		                </ol>
		                @endforeach
		                @endif
                	</ol>
                	@empty
                	<ol style="text-align:center;">
                    暂无评论
                	</ol>
                	@endforelse
               </div>
			</article>
			@parent
<script>
  //
  
  $("#postCom").click(function(){var n=$("input[name=parent_id]").val(),t=$("input[name=reply_to]").val(),a=$("input[name=reply_to_name]").val(),e=$("input[name=nick]").val(),i=$("input[name=email]").val(),o=$("textarea").val();return/.{2,8}/.test(e)?/^[0-9a-zA-Z]+@[0-9a-zA-Z]+\.[a-z]{2,5}$/.test(i)?$.trim(o)?void $.post('{{url("comment/store")}}/{{$field->art_id}}',{nick:e,email:i,content:o,parent_id:n,reply_to:t,reply_to_name:a,_token:"{{csrf_token()}}"},function(n){1==n.status?(window.location.reload(),layer.msg(n.msg,{icon:6})):layer.msg(n.msg,{icon:5})},"json"):(layer.msg("内容不能为空!",{icon:5}),!1):void layer.msg("邮箱格式不正确!",{icon:5}):void layer.msg("用户名必须为2-8个字符!",{icon:5})});

</script>
@endsection