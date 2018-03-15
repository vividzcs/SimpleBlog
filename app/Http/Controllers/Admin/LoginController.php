<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Crypt;
use App\Http\Model\User;

require_once('org/code/Code.class.php');

use App\Http\Requests;

class LoginController extends CommonController
{
    /**
	* login 登陆
	*
	*/
    public function login(){
      
    	// $u = User::first();
    	// dd($u['username']);
    	//判断是登陆还是要登陆
    	if($input = Input::all()){
    		$code = new \Code;
    		$_code = $code->get();
    		//dd($code->get());
    		//dd($input['code']);
    		//var_dump(($code->get() != $input['code']));exit();
    		if($_code != strtoupper($input['code'])){
    			return back()->with('msg','验证码错误');
    		}	
    		//到这说明验证码通过，然后检验用户名和密码
    		$user = User::first();
    		if($user['username'] != $input['username'] || Crypt::decrypt($user['password']) != $input['password']){
    			return back()->with('msg','用户名或密码错误');    		
    		}
    		
    		//到这说明通过验证，然后将用户信息写入session
    		session(['user'=>$user]);
    		return redirect('admin');
    	}else{
    		return view('admin.login');
    	}
    	
    }
   /**
   * code 生成验证码图片
   *
   */
   public function code(){
   		$code = new \Code;
   		$code->make();
   }
}
