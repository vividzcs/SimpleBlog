@extends('layouts.admin')

@section('content')
<script type="text/javascript" charset="utf-8" src="{{asset('org/ueditor/ueditor.config.js')}}"></script>
<script type="text/javascript" charset="utf-8" src="{{asset('org/ueditor/ueditor.all.min.js')}}"></script>
<script type="text/javascript" charset="utf-8" src="{{asset('org/ueditor/lang/zh-cn/zh-cn.js')}}"></script>

<body>
    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="{{url('admin/info')}}">首页</a> &raquo; 编辑系统文章
    </div>
    <!--面包屑导航 结束-->
    
    <!--结果集标题与导航组件 开始-->
    <div class="result_wrap">
        
        <div class="result_title">
            <div class="mark">
            @if(is_object($errors))
                @if (count($errors) >0)
                    @foreach($errors->all() as $v)
                    <p>{{$v}}</p>
                    @endforeach
                @endif
            @else
                <p>{{$errors}}</p>        
            @endif
        </div>
            <h3>快捷操作</h3>
        </div>
        <div class="result_content">
            <div class="short_wrap">
                <a href="{{url('admin/notice')}}"><i class="fa fa-plus"></i>全部系统文章</a>
                <a href="{{url('admin/notice/create')}}"><i class="fa fa-recycle"></i>添加系统文章</a>
            </div>
        </div>
    </div>
    <!--结果集标题与导航组件 结束-->
    <div class="result_wrap">
        <form action="{{url('admin/notice/' . $field->art_id)}}" method="post">
            <input type="hidden" name="_method" value="put">
            {{csrf_field()}}
            <table class="add_tab">
                <tbody>
                    
                    <tr>
                        <th><i class="require">*</i>系统文章标题：</th>
                        <td>
                            <input type="text" name="art_title" value="{{$field->art_title}}">
                            <span><i class="fa fa-exclamation-circle yellow"></i>系统文章标题必须填写</span>
                        </td>
                    </tr>
                    <tr>
                        <th>描述：</th>
                        <td>
                            <textarea name="art_description"></textarea>
                        </td>
                    </tr>
                    <tr>
                        <th><i class="require">*</i>系统文章标签：</th>
                        <td>
                            <input type="text" class="lg" name="art_tag" value="{{$field->art_tag}}">
                        </td>
                    </tr>

                    <tr>
                        <th><i class="require">*</i>编辑者：</th>
                        <td>
                            <input type="text" class="sm" name="art_editor" value="{{$field->art_editor}}">
                        </td>
                    </tr>
                    <tr>
                        <th><i class="require">*</i>系统文章内容：</th>
                        <td>
                            <textarea id="art_content" name="art_content">{!!$field->art_content!!}</textarea>
                        </td>
                    </tr>
                    
                    <tr>
                        <th></th>
                        <td>
                            <input type="submit" value="提交">
                            <input type="button" class="back" onclick="history.go(-1)" value="返回">
                        </td>
                    </tr>
                </tbody>
            </table>
        </form>
    </div>
<script type="text/javascript">
    var ue = UE.getEditor('art_content');
</script>
@endsection
