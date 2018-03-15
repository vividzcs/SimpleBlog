@extends('layouts.home')
@section('info')
<title>{{$field->art_title}}-{{Config::get('web.web_title')}}</title>
<meta name="keywords" content="{{$field->art_tag}}" />
<meta name="description" content="{{$field->art_description}}" />
<link href="{{asset('resources/views/home/css/new.css')}}" rel="stylesheet">
<link href="{{asset('resources/views/home/css/art.css')}}" rel="stylesheet">
<script type="text/javascript" src="{{asset('resources/views/admin/style/js/jquery.js')}}"></script>
<script type="text/javascript" src="{{asset('resources/views/org/layer/layer.js')}}"></script>
@endsection
@section('content')
<article class="blogs">
  <h1 class="t_nav"><span>您当前的位置：<a href="{{url('/')}}">首页</a>@foreach($par as $pa)&nbsp;&gt;&nbsp;<a href="{{url('cate/' . $pa->cate_id)}}">{{$pa->cate_name}}</a>@endforeach</span><a href="{{url('/')}}" class="n1">网站首页</a><a href="{{url('cate/' . $field->cate_id)}}" class="n2">{{$field->cate_name}}</a></h1>
  <div class="index_about">
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
    <div id="comments">
      <h2>评论</h2>
              @forelse($coms as $c)
                <ol>
                    <li>
                        <img src="{{asset('resources/views/home/images/unknow.jpg')}}" alt="">
                        <cite><a href="#">{{$c->nick}}</a></cite> <br>
                        <time>{{date('Y年m月d日 H时i分',$c->pubtime)}}</time>
                    </li>
                    <li>
                        {{$c->content}}
                    </li>
                </ol>
                @empty
                <ol style="text-align:center;">
                    暂无评论
                </ol>
                @endforelse
            </div>
            <div id="respond" class="comment-respond">
                <h3>留个言吧</h3>
                <form action="javascript::" method="post" id="com">
                    <p>
                    <input placeholder="昵称" name="nick" type="text" value="" size="30">
                    </p>
                    <p>
                    <input placeholder="Email" name="email" type="text" value="" size="30">
                    </p>
                    <p>
                    <textarea name="content" cols="45" rows="8" aria-required="true"></textarea>
                    <p>
                    <input id="postCom" type="button" value="发表留言">
                </p>
                </form>
            </div>
  </div>
  <aside class="right">
    <div class="blank"></div>
    <div class="news">
      @parent
    </div>
    <div class="visitors">
      <h3>
        <p>最近访客</p>
      </h3>
      <ul>
      </ul>
    </div>
  </aside>
</article>
<script>
  //
  
  $('#postCom').click(function(){
    var nick = $('input[name=nick]').val();
  var email = $('input[name=email]').val();
  var content = $('textarea').val();
      //检查昵称
      if(!$.trim(nick)){
          layer.msg('昵称不能为空!',{icon:5});
          return false;
      }
      //检查邮箱
      var patt=/^\w+@\w+.\w+$/;
      if(!patt.test(email)){
          layer.msg('请输入正确的邮箱!',{icon:5});
          return false;
      }
      //检查评论内容
      if(!$.trim(content)){
          layer.msg('内容不能为空!',{icon:5});
          return false;
      }
      //检查完毕
      $.post('{{url("comment/store")}}/'+{{$field->art_id}},{'nick':nick,'email':email,'content':content,'_token':'{{csrf_token()}}'},function(data){
                if(data.status == 1){
                    window.location.href = window.location.href;
                    layer.msg(data.msg,{icon:6});
                }else{
                    layer.msg(data.msg,{icon:5});   
                }
            },'json');
    });

</script>
@endsection