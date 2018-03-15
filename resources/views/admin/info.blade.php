<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
    <link rel="stylesheet" href="{{asset('style/css/ch-ui.admin.css')}}">
    <link rel="stylesheet" href="{{asset('style/font/css/font-awesome.min.css')}}">
</head>
<body>
	<!--面包屑导航 开始-->
	<div class="crumb_warp">
		<!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
		<i class="fa fa-home"></i> <a href="{{url('admin/info')}}">首页</a> &raquo; 系统基本信息
	</div>
	<!--面包屑导航 结束-->
	
	<!--结果集标题与导航组件 开始-->
	<div class="result_wrap">
        <div class="result_title">
            <h3>快捷操作</h3>
        </div>
        <div class="result_content">
            <div class="short_wrap">
                <a href="{{url('admin/article/create')}}"><i class="fa fa-plus"></i>新增文章</a>
                <a href="#"><i class="fa fa-recycle"></i>批量删除</a>
                <a href="#"><i class="fa fa-refresh"></i>更新排序</a>
            </div>
        </div>
    </div>
    <!--结果集标题与导航组件 结束-->

	
    <div class="result_wrap">
        <div class="result_title">
            <h3>系统基本信息</h3>
        </div>
        <div class="result_content">
            <ul>
                <li>
                    <label>操作系统</label><span>{{PHP_OS}}</span>
                </li>
                <li>
                    <label>运行环境</label><span>{{$_SERVER['SERVER_SOFTWARE']}}</span>
                </li>
                <li>
                    <label>邓邓设计-版本</label><span>v-0.1</span>
                </li>
                <li>
                    <label>上传附件限制</label><span><?php echo get_cfg_var("upload_max_filesize")?get_cfg_var("upload_max_filesize"):'不允许上传附件'?></span>
                </li>
                <li>
                    <label>北京时间</label><span><?php echo date('Y年m月d日 H:i:s');?></span>
                </li>
                <li>
                    <label>服务器域名/IP</label><span><?php echo $_SERVER['SERVER_NAME'],'&nbsp;[',$_SERVER['SERVER_ADDR'],']';?></span>
                </li>
                <li>
                    <label>Host</label><span><?php echo $_SERVER['SERVER_ADDR'];?></span>
                </li>
            </ul>
        </div>
    </div>


    <div class="result_wrap">
        <div class="result_title">
            <h3>使用帮助</h3>
        </div>
        <div class="result_content">
            <ul>
                <li>
                    <label>官方交流网站：</label><span><a href="{{url('/')}}">http://ilearnspace.cn</a></span>
                </li>
                <li>
                    <label>官方交流QQ群：</label><span><a target="_blank" href="//shang.qq.com/wpa/qunwpa?idkey=8afef21aeaf40303250a07d33d996730f674b25d2bc310497d28660984d4a19f"><img border="0" src="//pub.idqqimg.com/wpa/images/group.png" alt="前端后端交流圈子" title="前端后端交流圈子"></a></span>
                </li>
            </ul>
        </div>
    </div>
	<!--结果集列表组件 结束-->

</body>
</html>