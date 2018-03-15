<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Model\Notice;
use Illuminate\Support\Facades\Input;
use Validator;

class NoticeController extends CommonController
{
    /**
	* get admin.notice
	*/
	public function index(){
		$data = Notice::orderBy('art_id','desc')->paginate(10);
		//dd($data->links());
		return view('admin.notice.index',compact('data'));
	}

	/**
	* get admin.notice.create
	*/
	public function create(){
		return view('admin.notice.add');
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
		
				$rs = Notice::create($input);
				if($rs){
					return redirect('admin/notice');
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
	*put admin.notice/{notice}
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
			$rs = Notice::where('art_id',$art_id)->update($input);
			if($rs){
				return redirect('admin/notice');
			}else{
				return back()->with('errors','修改文章失败');
			}
			
		}else{
			//验证失败
			return back()->withErrors($validator);
		}
	}

	/**
	* get admin.notice/{notice}/edit
	*/
	public function edit($art_id){
		$field = Notice::find($art_id);
		return view('admin.notice.edit',compact('field'));
	}

	/**
	* delete admin.notice/{notice}
	*/
	public function destroy($art_id){
		
		$rs = Notice::where('art_id',$art_id)->delete();
		if($rs){
			//删除成功
			$msg = ['status' => 1 , 'msg' => '文章删除成功'];
		}else{
			$msg = ['status' => 0 , 'msg' => '文章删除失败'];
		}
		
		return $msg;
	}



}
