<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Model\Links;
use Validator;

class LinksController extends Controller
{
    /**
	* get admin.links
	*/
	public function index(){
		$data = Links::orderBy('link_order','asc')->get();
		//dd($data->links());
		return view('admin.links.index',compact('data'));
	}
	/**
	* get admin.links/{links}
	*/
	public function show(){}

	/**
	* 异步排序
	*/
	public function order(){
		$input = Input::all();
		$links = Links::find($input['link_id']);
		$links['link_order'] = $input['link_order'];
		$rs = $links->update();

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
	* get admin.links.create
	*/
	public function create(){
		return view('admin.links.add');
	}

	/**
	* post admin.links
	*/
	public function store(){
		$input = Input::except('_token');
		//dd($input);
		//验证
		$rules = [
			'link_name' => 'required',
			'link_url' => 'required'
		];
		$message = [
			'link_name.required' => '友情链接名称必须填写',
			'link_url.required' => '友情链接URL必须填写'
		];
		$validator = Validator::make($input,$rules,$message);
		if(!$validator->passes()){
			return back()->withErrors($validator);
		}else{
			$rs = Links::create($input);
			if($rs) {
				return redirect('admin/links');
			}else{
				return back()->with('errors','添加友情链接失败!');
			}
		}
	}

	/**
	* delete admin.link/{link}
	*/
	public function destroy($link_id){
		$rs = Links::where('link_id',$link_id)->delete();
		if($rs) {
			$msg = [
				'status' => 1,
				'msg' => '友情链接删除成功!'
			];
		}else{
			$msg = [
				'status' => 0,
				'msg' => '友情链接删除失败!'
			];
		}
		return $msg;
	}

	/**
	* get admin.links/{links}/edit
	*/
	public function edit($link_id){
		//echo $cate_id;
		$links = Links::find($link_id);
		//dd($cates);
		return view('admin.links.edit',compact('links'));
	}

	/**
	*put admin.links/{links}
	*/
	public function update($link_id){
		//接收表单信息
		$input = Input::except('_token','_method');
		//dd($input);
		//接收成功，开始验证
		$rules = [
			'link_name' => 'required',
			'link_url' => 'required'
		];
		$message = [
			'link_name.required' => '友情链接名不能为空',
			'link_title.required' => '友情链接标题不能为空'
		];
		$validator = Validator::make($input,$rules,$message);
		//dd($validator);
		if(!$validator->passes()){
			return back()->withErrors($validator);
		}else{
			//通过验证
			$rs = Links::where('link_id',$link_id)->update($input);
			if($rs){
				return redirect('admin/links');
			}else{
				return back()->with('errors','更新失败');
			}
		}

	}


}
