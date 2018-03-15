<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Model\Category;
use App\Http\Model\Article;
use Illuminate\Support\Facades\Input;
use Validator;

class ArticleController extends CommonController
{
    /**
	* get admin.article
	*/
	public function index(){
		$data = Article::orderBy('art_id','desc')->paginate(10);
		//dd($data->links());
		return view('admin.article.index',compact('data'));
	}

	/**
	* get admin.article.create
	*/
	public function create(){
		$cates = (new Category)->tree();
		
		return view('admin.article.add',compact('cates'));
	}

	/**
	* post admin.category 发表文章
	*/
	public function store(){
		$input = Input::except('_token');
		//dd($_FILES);
		$input['art_time'] = time();
		//dd($input);
		//验证
		$rules = [
			'art_title' => 'required',
			'art_tag' => 'required',
			'art_editor' => 'required',
			'art_content' => 'required'
		];
		$message = [
			'art_title.required' => '文章标题不能为空',
			'art_tag.required' => '文章标签不能为空',
			'art_editor.required' => '文章编辑者不能为空',
			'art_content.required' => '文章内容不能为空'
		];
		$validator = Validator::make($input,$rules,$message);
		if($validator->passes()){
			//验证通过
		
				$rs = Article::create($input);
				if($rs){
					//增加栏目的文章数
					Category::where('cate_id',$input['cate_id'])->increment('cate_count');
					return redirect('admin/article');
				}else{
					return back()->with('errors','添加文章失败');
				
			}
			
		}else{
			//验证失败
			return back()->withErrors($validator);
		}
	}
	/**
	* get admin.category/{category}
	*/
	public function show(){}

	
	/**
	*put admin.article/{article}
	*/
	public function update($art_id){
		$input = Input::except('_token','_method');
		//dd($input);
		//验证
		$rules = [
			'art_title' => 'required',
			'art_tag' => 'required',
			'art_editor' => 'required',
			'art_content' => 'required'
		];
		$message = [
			'art_title.required' => '文章标题不能为空',
			'art_tag.required' => '文章标签不能为空',
			'art_editor.required' => '文章编辑者不能为空',
			'art_content.required' => '文章内容不能为空'
		];
		$validator = Validator::make($input,$rules,$message);
		if($validator->passes()){
			//验证通过
			$rs = Article::where('art_id',$art_id)->update($input);
			if($rs){
				return redirect('admin/article');
			}else{
				return back()->with('errors','修改文章失败');
			}
			
		}else{
			//验证失败
			return back()->withErrors($validator);
		}
	}

	/**
	* get admin.article/{article}/edit
	*/
	public function edit($art_id){
		$cates = (new Category)->tree();
		$field = Article::find($art_id);
		return view('admin.article.edit',compact('cates','field'));
	}

	/**
	* delete admin.article/{article}
	*/
	public function destroy($art_id){
		$cate_id = Article::where('art_id',$art_id)->first()->cate_id;
		$rs = Article::where('art_id',$art_id)->delete();
		if($rs){
			//删除成功,栏目文章数-1
			Category::where('cate_id',$cate_id)->decrement('cate_count');
			$msg = ['status' => 1 , 'msg' => '文章删除成功'];
		}else{
			$msg = ['status' => 0 , 'msg' => '文章删除失败'];
		}
		
		return $msg;
	}



}
