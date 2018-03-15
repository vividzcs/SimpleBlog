<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Model\Nav;
use Illuminate\Support\Facades\Input;
use Validator;

class NavController extends Controller
{
    /**
	* get admin.nav
	*/
	public function index(){
		$data = Nav::orderBy('nav_order','asc')->get();
		//dd($data->navs());
		return view('admin.navs.index',compact('data'));
	}
	/**
	* get admin.navs/{navs}
	*/
	public function show(){}

	/**
	* 异步排序
	*/
	public function order(){
		$input = Input::all();
		$navs = Nav::find($input['nav_id']);
		$navs['nav_order'] = $input['nav_order'];
		$rs = $navs->update();

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
	* get admin.navs.create
	*/
	public function create(){
		return view('admin.navs.add');
	}

	/**
	* post admin.navs
	*/
	public function store(){
		$input = Input::except('_token');
		//dd($input);
		//验证
		$rules = [
			'nav_name' => 'required',
			'nav_url' => 'required',
			'nav_alias' => 'required'
		];
		$message = [
			'nav_name.required' => '自定义导航名不能为空',
			'nav_url.required' => '自定义导航链接不能为空',
			'nav_alias.required' => '自定义导航英文不能为空'
		];
		$validator = Validator::make($input,$rules,$message);
		if(!$validator->passes()){
			return back()->withErrors($validator);
		}else{
			$rs = Nav::create($input);
			if($rs) {
				return redirect('admin/navs');
			}else{
				return back()->with('errors','添加自定义导航失败!');
			}
		}
	}

	/**
	* delete admin.nav/{nav}
	*/
	public function destroy($nav_id){
		$rs = Nav::where('nav_id',$nav_id)->delete();
		if($rs) {
			$msg = [
				'status' => 1,
				'msg' => '自定义导航删除成功!'
			];
		}else{
			$msg = [
				'status' => 0,
				'msg' => '自定义导航删除失败!'
			];
		}
		return $msg;
	}

	/**
	* get admin.navs/{navs}/edit
	*/
	public function edit($nav_id){
		//echo $cate_id;
		$navs = Nav::find($nav_id);
		//dd($cates);
		return view('admin.navs.edit',compact('navs'));
	}

	/**
	*put admin.navs/{navs}
	*/
	public function update($nav_id){
		//接收表单信息
		$input = Input::except('_token','_method');
		//dd($input);
		//接收成功，开始验证
		$rules = [
			'nav_name' => 'required',
			'nav_url' => 'required',
			'nav_alias' => 'required'
		];
		$message = [
			'nav_name.required' => '自定义导航名不能为空',
			'nav_url.required' => '自定义导航链接不能为空',
			'nav_alias.required' => '自定义导航英文不能为空'
		];
		$validator = Validator::make($input,$rules,$message);
		//dd($validator);
		if(!$validator->passes()){
			return back()->withErrors($validator);
		}else{
			//通过验证
			$rs = Nav::where('nav_id',$nav_id)->update($input);
			if($rs){
				return redirect('admin/navs');
			}else{
				return back()->with('errors','更新失败');
			}
		}

	}
}
