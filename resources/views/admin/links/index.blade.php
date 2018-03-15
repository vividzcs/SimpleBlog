@extends('layouts.admin')

@section('content')
<body>
    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="{{url('admin/info')}}">首页</a> &raquo; 友情链接管理
    </div>
    <!--面包屑导航 结束-->


    <!--结果页快捷搜索框 开始-->
    <div class="search_wrap">

        <form action="" method="post">

            <table class="search_tab">
                <tr><!--快捷导航 开始-->
                    <td></td>
                    <td></div>
                    <h3>友情链接管理</h3>
                    </div></td>
                    
                </tr>
                <tr>
                    <td></td>
                    <td><div class="result_content">
                    <div class="short_wrap">
                    <a href="{{url('admin/links')}}"><i class="fa fa-plus"></i>链接列表</a>
                    <a href="{{url('admin/links/create')}}"><i class="fa fa-recycle"></i>添加链接</a>
                    </div>
                    </div>
                    <!--快捷导航 结束--></td>
                    
                </tr>
            </table>
        </form>
    </div>
    <!--结果页快捷搜索框 结束-->

    <!--搜索结果页面 列表 开始-->
    <form action="#" method="post">
        <div class="result_wrap">
            
        </div>
        <div class="result_wrap">
            <div class="result_content">
                <table class="list_tab">
                    <tr>
                        <th class="tc" width="5%">排序</th>
                        <th class="tc" width="5%">ID</th>
                        <th>链接名</th>
                        <th>链接标题</th>
                        <th>链接地址</th>
                        <th>发布时间</th>
                        <th>操作</th>
                    </tr>
                    @foreach($data as $v)
                    <tr>
                        <td class="tc">
                            <input type="text" onchange="changeOrder(this,{{$v['link_id']}});" value="{{$v['link_order']}}">
                        </td>
                        <td class="tc">{{$v['link_id']}}</td>
                        <td>
                            <a href="#">{{$v['link_name']}}</a>
                        </td>
                        <td>{{$v['link_title']}}</td>
                        <td>{{$v['link_url']}}</td>
                        <td>{{$v['pubtime']}}</td>
                        <td>
                            <a href="{{url('admin/links/' . $v->link_id . ' /edit')}}">修改</a>
                            <a href="javascript::" onclick="delLinks({{$v->link_id}});">删除</a>
                        </td>
                    </tr>
                    @endforeach
                   
                </table>


            </div>
        </div>
    </form>
    <!--搜索结果页面 列表 结束-->
    <script>
        function changeOrder(n,o){var i=$(n).val();$.post("{{url('admin/links/order')}}",{_token:"{{csrf_token()}}",link_order:i,link_id:o},function(n){1==n.status?layer.msg(n.msg,{icon:6}):layer.msg(n.msg,{icon:5})})}function delLinks(n){layer.confirm("您确定要删除此链接吗？",{btn:["删除","取消"]},function(){$.post("{{url('admin/links')}}/"+n,{_method:"delete",_token:"{{csrf_token()}}"},function(n){1==n.status?(window.location.href=window.location.href,layer.msg(n.msg,{icon:6})):layer.msg(n.msg,{icon:5})},"json")},function(){})}
    </script>
@endsection