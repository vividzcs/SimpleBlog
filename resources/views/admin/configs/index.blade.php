@extends('layouts.admin')

@section('content')
<body>
    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="{{url('admin/info')}}">首页</a> &raquo; 配置项管理
    </div>
    <!--面包屑导航 结束-->


    <!--结果页快捷搜索框 开始-->
    <div class="search_wrap">
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
        </div>
            <table class="search_tab">
                <tr><!--快捷导航 开始-->
                    <td></td>
                    <td></div>
                        
                    <h3>配置项管理</h3>

                    </div></td>
                    
                </tr>
                <tr>
                    <td></td>
                    <td><div class="result_content">
                    <div class="short_wrap">
                    <a href="{{url('admin/config')}}"><i class="fa fa-plus"></i>配置项列表</a>
                    <a href="{{url('admin/config/create')}}"><i class="fa fa-recycle"></i>添加配置项</a>
                    </div>
                    </div>
                    <!--快捷导航 结束--></td>
                    
                </tr>
            </table>
    </div>
    <!--结果页快捷搜索框 结束-->

    <!--搜索结果页面 列表 开始-->
    <form action="{{url('admin/config/changeContent')}}" method="post">
            {{csrf_field()}}
        <div class="result_wrap">
            
        </div>
        <div class="result_wrap">
            <div class="result_content">
                <table class="list_tab">
                    <tr>
                        <th class="tc" width="5%">排序</th>
                        <th class="tc" width="5%">ID</th>
                        <th>配置标题</th>
                        <th>配置项名称</th>
                        <th>内容</th>
                        <th>操作</th>
                    </tr>
                    @foreach($data as $v)
                    <tr>
                        <td class="tc">
                            <input type="text" onchange="changeOrder(this,{{$v['conf_id']}});" value="{{$v['conf_order']}}">
                        </td>
                        <td class="tc">{{$v['conf_id']}}</td>
                        <td>
                            <a href="#">{{$v['conf_title']}}</a>
                        </td>
                        <td>{{$v['conf_name']}}</td>
                        <td>
                            <input type="hidden" name="conf_id[]" value="{{$v['conf_id']}}">
                            {!!$v['_html']!!}
                        </td>
                        <td>
                            <a href="{{url('admin/config/' . $v->conf_id . ' /edit')}}">修改</a>
                            <a href="javascript::" onclick="delConfig({{$v->conf_id}});">删除</a>
                        </td>
                    </tr>
                    @endforeach
                   
                </table>
                <div class="btn_group">
                <input type="submit" value="提交">
                <input type="button" class="back" onclick="history.go(-1)" value="返回" >
                </div>

            </div>
        </div>
    </form>
    <!--搜索结果页面 列表 结束-->
    <script>
        function changeOrder(n,o){var i=$(n).val();$.post("{{url('admin/config/order')}}",{_token:"{{csrf_token()}}",conf_order:i,conf_id:o},function(n){1==n.status?layer.msg(n.msg,{icon:6}):layer.msg(n.msg,{icon:5})})}function delConfig(n){layer.confirm("您确定要删除此配置项吗？",{btn:["删除","取消"]},function(){$.post("{{url('admin/config')}}/"+n,{_method:"delete",_token:"{{csrf_token()}}"},function(n){1==n.status?(window.location.href=window.location.href,layer.msg(n.msg,{icon:6})):layer.msg(n.msg,{icon:5})},"json")},function(){})}
    </script>
@endsection