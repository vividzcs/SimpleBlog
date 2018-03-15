@extends('layouts.admin')

@section('content')
<script type="text/javascript" charset="utf-8" src="{{asset('org/ueditor/ueditor.config.js')}}"></script>
<script type="text/javascript" charset="utf-8" src="{{asset('org/ueditor/ueditor.all.min.js')}}"></script>
<script type="text/javascript" charset="utf-8" src="{{asset('org/ueditor/lang/zh-cn/zh-cn.js')}}"></script>
<script src="{{asset('org/uploadify/jquery.uploadify.min.js')}}" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" href="{{asset('org/uploadify/uploadify.css')}}">
<style>
    .edui-default{line-height: 28px;}
    div.edui-combox-body,div.edui-button-body,div.edui-splitbutton-body
    {overflow: hidden; height:20px;}
    div.edui-box{overflow: hidden; height:22px;}
    .uploadify{display:inline-block;}
    .uploadify-button{border:none; border-radius:5px; margin-top:8px;}
    table.add_tab tr td span.uploadify-button-text{color: #FFF; margin:0;}
</style>
</style>
<body>
    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="{{url('admin/info')}}">首页</a> &raquo; 添加文章
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
                <a href="{{url('admin/article')}}"><i class="fa fa-plus"></i>全部文章</a>
                <a href="{{url('admin/article/create')}}"><i class="fa fa-recycle"></i>添加文章</a>
            </div>
        </div>
    </div>
    <!--结果集标题与导航组件 结束-->
    
    <div class="result_wrap">
        <form action="{{url('admin/article')}}" method="post" enctype="multipart/form-data">
            {{csrf_field()}}
            <table class="add_tab">
                <tbody>
                    <tr>
                        <th width="120"><i class="require"></i>分类：</th>
                        <td>
                            <select name="cate_id">
                                @foreach($cates as $d)
                                <option value="{{$d['cate_id']}}">{{str_repeat('&nbsp;&nbsp;&nbsp;',$d['lev']) . $d['cate_name']}}</option>
                                @endforeach
                            </select>
                        </td>
                    </tr>
                     <tr>
                        <th><i class="require">*</i>文章标题：</th>
                        <td>
                            <input type="text" name="art_title">
                            <span><i class="fa fa-exclamation-circle yellow"></i>文章标题必须填写</span>
                        </td>
                    </tr>
                    <tr>
                        <th><i class="require">*</i>文章标签：</th>
                        <td>
                            <input type="text" class="lg" name="art_tag">
                        </td>
                    </tr>
                    <tr>
                        <th><i class="require">*</i>编辑者：</th>
                        <td>
                            <input type="text" class="sm" name="art_editor">
                        </td>
                    </tr>
                    <tr>
                        <th>描述：</th>
                        <td>
                            <textarea name="art_description"></textarea>
                        </td>
                    </tr>
                    <tr>
                        <th>缩略图：</th>
                        <td>
                            <input type="text" size="50" name="art_thumb" value="">
                            <input id="file_upload" name="file_upload" type="file" multiple="true">
                        </td>
                    </tr>
                    <tr>
                        <th></th>
                        <td>
                            <img src="" alt="" id="art_thumb_pre" style="max-width:380px;max-height:100px;">
                        </td>
                    </tr>
                    <tr>
                        <th><i class="require">*</i>文章内容：</th>
                        <td>
                            <script id="art_content" name="art_content"></script>
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
    //图片上传
    <?php $timestamp = time();?>
        $(function(){$("#file_upload").uploadify({buttonText:"图片上传",formData:{timestamp:"<?php echo $timestamp;?>",_token:"{{csrf_token()}}"},swf:"{{asset('org/uploadify/uploadify.swf')}}",uploader:"{{url('admin/upload')}}",onUploadSuccess:function(t,a,o){o&&($("input[name=art_thumb]").val(a),$("#art_thumb_pre").attr("src","/storage/"+a))}})});
</script>
@endsection
