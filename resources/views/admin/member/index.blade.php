@extends('layouts.admin')
@section('content')
<style>
    .result_content ul li span {
        padding: 6px 12px;
        font-size: 15px;
    }
</style>
<body>
    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="{{url('admin/info')}}">首页</a> &raquo; 全部会员
    </div>
    <!--面包屑导航 结束-->

    <!--结果页快捷搜索框 开始-->
    <div class="search_wrap">
        <form action="" method="post">
            <table class="search_tab">
                <tr>
                    <th width="120">选择分类:</th>
                    <td>
                        <select onchange="javascript:location.href=this.value;">
                            <option value="">全部</option>
                            <option value="http://www.baidu.com">百度</option>
                            <option value="http://www.sina.com">新浪</option>
                        </select>
                    </td>
                    <th width="70">关键字:</th>
                    <td><input type="text" name="keywords" placeholder="关键字"></td>
                    <td><input type="submit" name="sub" value="查询"></td>
                </tr>
            </table>
        </form>
    </div>
    <!--结果页快捷搜索框 结束-->

    <!--搜索结果页面 列表 开始-->
    <form action="#" method="post">
        <div class="result_wrap">
            <!--快捷导航 开始-->
            <div class="result_content">
                <div class="short_wrap">
                    <a href="{{url('admin/member')}}"><i class="fa fa-plus"></i>全部会员</a>
                </div>
            </div>
            <!--快捷导航 结束-->
        </div>

        <div class="result_wrap">
            <div class="result_content">
                <table class="list_tab">
                    <tr>
                        <th class="tc">ID</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Register_at</th>
                        <th>LastLogin</th>
                        <th>操作</th>
                    </tr>
                    @foreach($data as $v)
                    <tr>
                        <td class="tc">{{$v->member_id}}</td>
                        <td>{{$v->username}}</td>
                        <td>{{$v->email}}</td>
                        <td>{{date('Y-m-d H:i:s',$v->register_at)}}</td>
                        <td>{{date('Y-m-d H:i:s',$v->lastlogin)}}</td>
                        <td>
                            <a href="javascript::" onclick="delArt({{$v->member_id}})">删除</a>
                        </td>
                    </tr>
                    @endforeach
                </table>

                <div class="page_list">
                    {{$data->links()}}
                </div>
            </div>
        </div>
    </form>
    <!--搜索结果页面 列表 结束-->
    <script>
        function delArt(n){layer.confirm("您确定要删除此会员吗？",{btn:["删除","取消"]},function(){$.post("{{url('admin/member')}}/"+n,{_token:"{{csrf_token()}}"},function(n){1==n.status?(window.location.href=window.location.href,layer.msg(n.msg,{icon:6})):layer.msg(n.msg,{icon:5})},"json")},function(){})}
    </script>
@endsection
