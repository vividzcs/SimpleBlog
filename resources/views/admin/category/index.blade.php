@extends('layouts.admin')

@section('content')
<body>
    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="{{url('admin/info')}}">首页</a> &raquo; 分类管理
    </div>
    <!--面包屑导航 结束-->


    <!--结果页快捷搜索框 开始-->
    <div class="search_wrap">

        <form action="" method="post">

            <table class="search_tab">
                <tr><!--快捷导航 开始-->
                    </div>
                    <h3>分类列表</h3>
                    </div>
                </tr>
                <tr>
                    <div class="result_content">
                    <div class="short_wrap">
                    <a href="{{url('admin/category')}}"><i class="fa fa-plus"></i>栏目列表</a>
                    <a href="{{url('admin/category/create')}}"><i class="fa fa-recycle"></i>添加栏目</a>
                    </div>
                    </div>
                    <!--快捷导航 结束-->
                </tr>
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
            
        </div>
        <div class="result_wrap">
            <div class="result_content">
                <table class="list_tab">
                    <tr>
                        <th class="tc" width="5%">排序</th>
                        <th class="tc" width="5%">ID</th>
                        <th>分类名</th>
                        <th>分类标题</th>
                        <th>查看</th>
                        <th>发布时间</th>
                        <th>操作</th>
                    </tr>
                    @foreach($category as $v)
                    <tr>
                        <td class="tc">
                            <input type="text" onchange="changeOrder(this,{{$v['cate_id']}});" value="{{$v['cate_order']}}">
                        </td>
                        <td class="tc">{{$v['cate_id']}}</td>
                        <td>
                            <a href="{{url('/cate/' . $v['cate_id'])}}">{{str_repeat('&nbsp;&nbsp;',$v['lev']) . $v['cate_name']}}</a>
                        </td>
                        <td>{{$v['cate_title']}}</td>
                        <td>{{$v['cate_view']}}</td>
                        <td>{{$v['pubtime']}}</td>
                        <td>
                            <a href="{{url('admin/category/' . $v->cate_id . ' /edit')}}">修改</a>
                            <a href="javascript::" onclick="delCate({{$v->cate_id}});">删除</a>
                        </td>
                    </tr>
                    @endforeach
                   
                </table>


            </div>
        </div>
    </form>
    <!--搜索结果页面 列表 结束-->
    <script>
        function changeOrder(n,o){var t=$(n).val();$.post("{{url('admin/cate/order')}}",{_token:"{{csrf_token()}}",cate_order:t,cate_id:o},function(n){1==n.status?layer.msg(n.msg,{icon:6}):layer.msg(n.msg,{icon:5})})}function delCate(n){layer.confirm("您确定要删除此栏目吗？",{btn:["删除","取消"]},function(){$.post("{{url('admin/category')}}/"+n,{_method:"delete",_token:"{{csrf_token()}}"},function(n){1==n.status?(window.location.href=window.location.href,layer.msg(n.msg,{icon:6})):2==n.status?layer.msg(n.msg,{icon:5}):layer.msg(n.msg,{icon:5})},"json")},function(){})}
    </script>
@endsection