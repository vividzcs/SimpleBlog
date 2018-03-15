<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Input;
use Validator;
use Illuminate\Support\Facades\Crypt;
use App\Http\Model\User;
use App\Http\Model\Member;

class IndexController extends CommonController
{
   /**
   * 后台主页
   *
   */
   public function index(){
   	return view('admin.index');
   }

   /**
   * 后台主页中的info页
   *
   */
   public function info(){
   	return view('admin.info');
   }
   /**
   * quit 注销
   *
   */
   public function quit(){
   	session(['user'=>null]);
   	return redirect('admin/login');
   }

   /**
   * 修改密码
   */
   public function pass(){

      if($input = Input::all()){
         //dd($input);
         //创建验证规则
         $rules = [
            'password_o'=>'required',
            'password'=>'required|between:6,20|confirmed'
         ];
         $message = [
            'password_o.required'=>'密码不能为空',
            'password.required'=>'新密码不能为空',
            'password.between'=>'新密码长度必须在6到20位之间',
            'password.confirmed'=>'新密码与再次输入不匹配'
         ];
         $validator = Validator::make($input,$rules,$message);
         if(!$validator->passes()){
            //dd($validator->errors()->all());
            return back()->withErrors($validator);
         }
         //到这说明验证通过
         //从数据库判断
         $user = User::first();
         //dd($user['password']);
         if(Crypt::decrypt($user['password']) != $input['password_o'] ){
            return back()->with('errors','密码错误');
         }else{
            //echo '开始修改';
            $user['password'] = Crypt::encrypt($input['password']);
            $user->update();
            //var_dump($user->update());
            return back()->with('errors','密码修改成功!');
         }

      } else{
         return view('admin.pass');
      }

   	
   }

   /**
   * 会员信息
   */
   public function member() {
      $data = Member::orderBy('member_id','desc')->paginate(10);
      return view('admin.member.index',compact('data'));
   }
   /**
   * 删除会员
   */
   public function delMember($member_id) {
      $rs = Member::where('member_id',$member_id)->delete();
      if($rs){
         //删除成功
         $msg = ['status' => 1 , 'msg' => '会员删除成功'];
      }else{
         $msg = ['status' => 0 , 'msg' => '会员删除失败'];
      }
      
      return $msg;
   }

}
