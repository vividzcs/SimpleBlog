<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

class CommonController extends Controller
{
    //图片上传
    public function upload(){
    	$input = Input::file('Filedata');
    	//dd($input);
    	if($input->isValid()){
    		//证明上传图片成功
    		$extension = $input->getClientOriginalExtension(); //获取上传文件的后缀
    		$newName = date('YmdHis') . mt_rand(1000,9999) .'.' . $extension;
    		$filepath = $input->move(base_path() . '/uploads',$newName);
    		//dd($filepath);
    		return 'uploads/' . $newName;
    	}
    }
}
