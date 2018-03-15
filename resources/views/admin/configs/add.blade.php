@extends('layouts.admin')

@section('content')
<body>
    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="{{url('admin/info')}}">首页</a> &raquo; 添加配置项
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
                <a href="{{url('admin/config')}}"><i class="fa fa-plus"></i>配置项列表</a>
                <a href="{{url('admin/config/create')}}"><i class="fa fa-recycle"></i>添加配置项</a>
            </div>
        </div>
    </div>
    <!--结果集标题与导航组件 结束-->
    
    <div class="result_wrap">
        <form action="{{url('admin/config')}}" method="post">
            {{csrf_field()}}
            <table class="add_tab">
                <tbody>
                    <tr>
                        <th><i class="require">*</i>配置项标题：</th>
                        <td>
                            <input type="text" name="conf_title">
                            <span><i class="fa fa-exclamation-circle yellow"></i>配置项标题必须填写</span>
                        </td>
                    </tr>
                     <tr>
                        <th><i class="require">*</i>配置项名称：</th>
                        <td>
                            <input type="text" name="conf_name">
                            <span><i class="fa fa-exclamation-circle yellow"></i>配置项名称必须填写</span>
                        </td>
                    </tr>
                    <tr>
                        <th><i class="require">*</i>配置项类型：</th>
                        <td>
                            <input type="radio" name="field_type" onclick="changeTr();" value="input" checked>input　
                            <input type="radio" name="field_type" onclick="changeTr();" value="textarea">textarea　
                            <input type="radio" name="field_type" onclick="changeTr();" value="radio">radio 
                        </td>
                    </tr>
                    <tr class="field_value">
                        <th>类型值</th>
                        <td>
                            <input type="text" name="field_value">
                            <sapn><i class="fa fa-exclamation-circle yellow"></i>类型值在radio才需要填写，格式 : 1|开启,0|关闭</span>
                        </td>
                    </tr>
                    <tr>
                        <th>说明：</th>
                        <td>
                            <textarea id="" cols="30" rows="10" name="conf_tips"></textarea>
                        </td>
                    </tr>
                    
                    
                    <tr>
                        <th>排序：</th>
                        <td>
                            <input type="text" class="sm" name="conf_order" value="0">
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
<script>
    function changeTr(){var e=$("input[name=field_type]:checked").val(),a=$(".field_value");"radio"==e?a.show():a.hide()}changeTr();
</script>
@endsection
