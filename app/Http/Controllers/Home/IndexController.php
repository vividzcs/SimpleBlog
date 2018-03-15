<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

use App\Http\Requests;
use App\Http\Model\Nav;
use App\Http\Controllers\Controller;
use App\Http\Model\Article;
use App\Http\Model\Category;
use App\Http\Model\Links;
use App\Http\Model\Comment;
use App\Http\Model\Notice;
use App\Http\Model\Member;
use Illuminate\Support\Facades\Crypt;

class IndexController extends Controller
{
	public function __construct(){
        //友情链接
        $links = Links::all();

		$navs = Nav::all();
        //5篇点击排行
        $point = Article::orderBy('art_view','desc')->take(5)->get();
        $cates = (new Category)->tree();
        //修改用户登录信息
        if(!empty(session('member'))){
            if(is_array(session('member'))){
                $username = session('member')['username'];
                $password = session('member')['password'];
            }else{
                $username = session('member')->username;
                $password = session('member')->password;
            }
            
            //dd($password);
            $mem = Member::where('username',$username)->where('password',$password)->first();
            if(!empty($mem)){
                View::share('mem',$mem);
            }
        }
        View::share('navs',$navs);
        View::share('point',$point);
        View::share('cates',$cates);
        View::share('links',$links);
	}
	/**
	* 前台首页
	*/
    public function index(){
    	
    	//网站配置项
        //5篇图文列表
        $data = Article::join('category','category.cate_id','=','article.cate_id')->select('article.*','category.cate_name')->orderBy('art_time','desc')->paginate(8);


    	return view('home.index',compact('data'));
    }

    /**
    * 前台栏目页
    */
    public function cate($cate_id){
        Category::where('cate_id',$cate_id)->increment('cate_view');
    	$cateinfo = Category::find($cate_id);
    	$data = (new Article)->getCateArticle($cate_id);
    	$submenu = (new Category)->getSub($cate_id);
        return view('home.list',compact('cateinfo','data','submenu'));
    }

    /**
    * 前台文章页
    */
    public function article($art_id){
        Article::where('art_id',$art_id)->increment('art_view');
        $field = Article::join('category','article.cate_id','=','category.cate_id')->select('article.*','category.cate_name')->where('art_id',$art_id)->first();
    	$par = (new Category)->getPar($field->cate_id);
        //上一篇下一篇
        $article['pre'] = Article::where('art_id',$art_id-1)->first();
        $article['next'] = Article::where('art_id',$art_id+1)->first();
        //相关文章
        $data = Article::where('cate_id',$field->cate_id)->orderBy('art_view','desc')->take(6)->get();

        //评论
        $coms = (new Comment)->getComment($art_id);

        return view('home.new',compact('field','par','article','data','coms'));
    }

    /**
    * 系统文章
    */
    public function notice($art_id) {
        $field = Notice::find($art_id);
        //增加阅读数
        Notice::where('art_id',$art_id)->increment('art_view');
        return view('home.notice',compact('field'));
    }
    
    /**
    * 用户登录
    */
    public function login () {
        return view('home.login');
    }

    /**
    * 用户注册
    */
    public function register () {
        return view('home.register');
    }

}
