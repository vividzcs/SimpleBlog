<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Model\Category;
use Illuminate\Support\Facades\Input;
use Validator;

class CategoryController extends CommonController
{
	/**
	* post admin.category
	*/
	public function store(){
		$input = Input::except('_token');
		//dd($input);
		//验证
		$rules = [
			'cate_name' => 'required',
			'cate_title' => 'required'
		];
		$message = [
			'cate_name.required' => '分类名称必须填写',
			'cate_title.required' => '分类标题必须填写'
		];
		$validator = Validator::make($input,$rules,$message);
		if(!$validator->passes()){
			return back()->withErrors($validator);
		}else{
			$rs = Category::create($input);
			if($rs) {
				return redirect('admin/category');
			}else{
				return back()->with('errors','添加分类失败!');
			}
		}
	}

	/**
	* get admin.category
	*/
	public function index(){
		$category = (new Category)->tree();
		//dd($category);
		return view('admin.category.index')->with('category',$category);
	}

	/**
	* order排序
	*/
	public function order(){
		$input = Input::all();
		//echo $input['cate_order'];
		//echo 2333;
		//开始修改
		$cate = Category::find($input['cate_id']);
		$cate['cate_order'] = $input['cate_order'];
		$rs = $cate->update();
		if($rs) {
			$data = [
				'status' => 1,
				'msg' => '更改成功'
			];
		}else{
			$data = [
				'status' => 1,
				'msg' => '更改成功'
			];
		}
		return $data;
	}

	/**
	* get admin.category.create
	*/
	public function create(){
		$cates = (new Category)->tree();
		return view('admin.category.add',compact('cates'));
	}

	/**
	* delete admin.category/{category}
	*/
	public function destroy($cate_id){
		//echo $cate_id;
		//判断要删除的栏目下有没有子栏目，如果有，不允许删除
		$em = Category::where('cate_pid',$cate_id)->first();
		//dd(empty($em));
		if(!$em){
			$rs = Category::where('cate_id',$cate_id)->delete();
			if($rs){
				//删除成功
				$msg = ['status' => 1 , 'msg' => '栏目删除成功'];
			}else{
				$msg = ['status' => 0 , 'msg' => '栏目删除失败'];
			}
			
		}else{
			$msg = ['status' => 2,'msg' => '此栏目非空。不允许删除!'];
		}
		return $msg;
	}

	/**
	*put admin.category/{category}
	*/
	public function update($cate_id){
		//接收表单信息
		$input = Input::except('_token','_method');
		//dd($input);
		//接收成功，开始验证
		$rules = [
			'cate_name' => 'required',
			'cate_title' => 'required',
			'cate_order' =>'numeric'
		];
		$message = [
			'cate_name.required' => '栏目名不能为空',
			'cate_title.required' => '栏目标题不能为空',
			'cate_order.numeric' => '排序必须为数字'
		];
		$validator = Validator::make($input,$rules,$message);
		//dd($validator);
		if(!$validator->passes()){
			return back()->withErrors($validator);
		}else{
			//通过验证
			$rs = Category::where('cate_id',$cate_id)->update($input);
			if($rs){
				return redirect('admin/category');
			}else{
				return back()->with('errors','更新失败');
			}
		}

	}

	/**
	* get admin.category/{category}
	*/
	public function show(){}

	/**
	* get admin.category/{category}/edit
	*/
	public function edit($cate_id){
		//echo $cate_id;
		$cate = Category::find($cate_id);
		$cates = (new Category)->tree();
		//dd($cates);
		return view('admin.category.edit',compact('cates','cate'));
	}

}
