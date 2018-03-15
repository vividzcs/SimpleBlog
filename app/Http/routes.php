<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/



/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

Route::group(['middleware' => ['web','admin.login'],'prefix'=>'admin','namespace'=>'Admin'], function () {
    
    //登陆成功进入后台主页
	Route::get('/','IndexController@index');
	//注销
	Route::get('quit','IndexController@quit');
	//后台主页中的info也
	Route::get('info','IndexController@info');
	//修改密码
	Route::match(['post','get'],'pass','IndexController@pass');	
	//分类
	Route::resource('category','CategoryController');
	Route::post('cate/order','CategoryController@order');
	//文章
	Route::resource('article','ArticleController');
	Route::post('upload','CommonController@upload');
	//链接
	Route::resource('links','LinksController');
	Route::post('links/order','LinksController@order');
	//自定义导航
	Route::resource('navs','NavController');
	Route::post('navs/order','NavController@order');
	//配置项
	Route::resource('config','ConfigController');
	Route::post('config/order','ConfigController@order');
	Route::post('config/changeContent','ConfigController@changeContent');
	Route::get('configs/putfile','ConfigController@putFile');
	//系统文章
	Route::resource('notice','NoticeController');
	//会员
	Route::get('member','IndexController@member');
	Route::post('member/{member_id}','IndexController@delMember')->where('member_id','[0-9]+');

	
});

Route::group(['middleware' => ['web','admin.login'],'prefix'=>'admin','namespace'=>'Home'], function () {
    //评论
    Route::get('comment','CommentController@index');
    Route::post('comment/{comment_id}','CommentController@destroy')->where('comment_id','[0-9]+');

   
});

Route::group(['middleware' => ['web'],'prefix'=>'admin','namespace'=>'Admin'], function () {
    //登陆后台与验证码
	Route::match(['get','post'],'login','LoginController@login');
	Route::get('code','LoginController@code');

});

Route::group(['middleware' => ['web'],'namespace' => 'Home'], function () {
	Route::get('/','IndexController@index');
	Route::get('/cate/{cate_id}','IndexController@cate')->where('cate_id','[0-9]+');;
	Route::get('/a/{art_id}','IndexController@article')->where('art_id','[0-9]+');
	//系统文章
	Route::get('/n/{art_id}','IndexController@notice')->where('art_id','[0-9]+');

	//用户登陆与注册
	Route::get('/login','IndexController@login');
	Route::get('/register','IndexController@register');
	Route::get('/logout','MemberController@logout');

	Route::post('/member/login','MemberController@login');
	Route::post('/member/register','MemberController@register');


	Route::get('/member/registerConfirm/{username}/{email}/{password}','MemberController@registerConfirm');


});

//回复与邮件发送
Route::group(['middleware' => ['web','comment.store']], function() {
	//评论
    Route::post('comment/store/{art_id}','Home\CommentController@store');

});


