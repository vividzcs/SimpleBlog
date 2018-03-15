<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Crypt;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Model\Member;

class MemberController extends Controller
{
    //
    public function login() {
    	$input = Input::except('_token');
    	//验证

    	if(!preg_match('/^.{2,12}$/', $input['username'])) {
    		$data = [
    			'status' => 0,
    			'msg' => '用户名必须为2-8个字符!'
    		];
    		return $data;
    	}
    	if(!preg_match('/^[0-9a-zA-Z]{6,}$/', $input['password'])) {
    		$data = [
    			'status' => 0,
    			'msg' => '密码不小于6位!'
    		];
    		return $data;
    	}
    	//验证通过，开始与数据库比对
    	$member = Member::where('username',$input['username'])->first();
    	if(empty($member) || Crypt::decrypt($member->password) !== $input['password']) {
    		$data = [
    			'status' => 0,
    			'msg' => '用户名或密码错误!'
    		];
    		return $data;
    	}
    	
    	//验证都通过
    	session(['member'=>$member]);
        $lastlogin = time();
        Member::where('member_id',$member->member_id)->update(['lastlogin'=>$lastlogin]);
    	$data = [
    			'status' => 1,
    			'msg' => '登录成功!'
    		];
    		return $data;

    }

    public function logout(){
        session(['member' => null]);
        return redirect('/');
    }

    public function register(){
    	$input = Input::except('_token');
    	//验证数据
    	if(!preg_match('/^.{2,12}$/', $input['username'])) {
    		$data = [
    			'status' => 0,
    			'msg' => '用户名必须为2-8个字符!'
    		];
    		return $data;
    	}
    	if(!preg_match('/^[0-9a-zA-Z]+@[0-9a-zA-Z]+\.[a-z]{2,5}$/', $input['email'])) {
    		$data = [
    			'status' => 0,
    			'msg' => '请填写正确的邮箱!'
    		];
    		return $data;
    	}
    	if(!preg_match('/^[0-9a-zA-Z]{6,}$/', $input['password'])) {
    		$data = [
    			'status' => 0,
    			'msg' => '密码不小于6位!'
    		];
    		return $data;
    	}
    	//检验用户名邮箱是否有重复
    	$has = Member::where('username',$input['username'])->first();
    	if(!empty($has)){
    		$data = [
    			'status' => 0,
    			'msg' => '用户名已经被注册!'
    		];
    		return $data;
    	}
    	$has = Member::where('email',$input['email'])->first();
    	if(!empty($has)){
    		$data = [
    			'status' => 0,
    			'msg' => '邮箱已经被注册!'
    		];
    		return $data;
    	}
    	//验证通过,开始入库
        //开始发邮件，检验邮箱是否有效
        
        $username = base64_encode($input['username']);
        $email = base64_encode($input['email']);
        $password = base64_encode($input['password']);
        $url = 'http://www.ilearnspace.cn/member/registerConfirm/' . $username . '/' . $email . '/' . $password;
        //dd($url);
        $content = '你好，你刚在止戈个人博客注册了用户，请点击下面的链接进行确认,如果不是本人操作，请忽略此邮件:<br/><br/>';
        $receiver = $input['email'];
        $receiverName = $input['username'];
        $body = $content . '注册确认:' . $url;
        $mail = new \PHPMailer;   //生成一个PHPMailer对象
        $mail->isSMTP();   //用SMTP发送
        $mail->Host = 'smtp.qq.com';  //发送文件的服务器，邮件一般要先经过这个服务器
        $mail->Port = 465;
        $mail->SMTPSecure = 'ssl';
        $mail->SMTPAuth = true;
        $mail->SMTPKeepAlive = true; // SMTP connection will not close after each email sent, reduces SMTP overhead
        // $mail->SMTPDebug = 1;
        // $mail->Port = 25;
        $mail->Username = '1747789689';
        $mail->Password = 'qqsktqgxihrqbhch';
        $mail->setFrom('1747789689@qq.com', '止戈的个人博客');
        $mail->addReplyTo('1747789689@qq.com', '止戈');
        $mail->Subject = "你好,你刚才在止戈个人博客注册了用户!请进入邮箱确认!";
        //Same body for all messages, so set this before the sending loop
        //If you generate a different body for each recipient (e.g. you're using a templating system),
        //set it inside the loop
        $mail->msgHTML($body);
        //msgHTML also sets AltBody, but if you want a custom one, set it afterwards
        $mail->AltBody = '你好,你刚才在止戈个人博客注册了用户!请进入邮箱确认!';
        //添加收件人的邮箱地址
        $mail->addAddress($receiver,$receiverName);
        $mail->addAddress('1747789689@qq.com','止戈');
        
        // dd($mail->send());
        if ($mail->send()) {
            // Clear all addresses for next loop
            $mail->clearAddresses();
            $msg = [
                    'status' => 1,
                    'msg' => '注册成功一半!请登录邮箱确认!'
                ];
            return $msg;
        } else {
            $msg = [
                'status' => 0,
                'msg' => '注册失败，请稍后重试!或联系博主'
            ];
            return $msg;
        
        }





    	
    }

    /**
    * 接收从邮件过来的参数
    */
    public function registerConfirm(Request $req) {
        $username = base64_decode($req->username);
        $email = base64_decode($req->email);
        $password = base64_decode($req->password);
        $url = 'http://www.ilearnspace.cn/member/registerConfirm/' . $username . '/' . $email . '/' . $password;
        //验证数据
        $input['username'] = $username;
        $input['email'] = $email;
        $input['password'] = $password;
        if(!preg_match('/^.{2,12}$/', $input['username'])) {
            $rdata = [
                'status' => 0,
                'msg' => '用户名必须为2-8个字符!'
            ];
            $rdata = json_encode($rdata);
            return view('home.register',compact('rdata'));
        }
        if(!preg_match('/^[0-9a-zA-Z]+@[0-9a-zA-Z]+\.[a-z]{2,5}$/', $input['email'])) {
            $rdata = [
                'status' => 0,
                'msg' => '请填写正确的邮箱!'
            ];
            $rdata = json_encode($rdata);
            return view('home.register',compact('rdata'));
        }
        if(!preg_match('/^[0-9a-zA-Z]{6,}$/', $input['password'])) {
            $rdata = [
                'status' => 0,
                'msg' => '密码不小于6位!'
            ];
            $rdata = json_encode($rdata);
            return view('home.register',compact('rdata'));
        }
        //检验用户名邮箱是否有重复
        $has = Member::where('username',$input['username'])->first();
        if(!empty($has)){
            $rdata = [
                'status' => 0,
                'msg' => '用户名已经被注册!'
            ];
            $rdata = json_encode($rdata);
            return view('home.register',compact('rdata'));
        }
        $has = Member::where('email',$input['email'])->first();
        if(!empty($has)){
            $rdata = [
                'status' => 0,
                'msg' => '邮箱已经被注册!'
            ];
            $rdata = json_encode($rdata);
            return view('home.register',compact('rdata'));
        }
        //验证通过,开始入库
        $input['register_at'] = time();
        $input['lastlogin'] = time();
        $input['password'] = Crypt::encrypt($input['password']);
        // dd($input);
        $rs = Member::create($input);
        if($rs) {
            session(['member'=>$input]);
            $rdata = [
                'status' => 1,
                'msg' => '注册成功!'
            ];
            $rdata = json_encode($rdata);
            return view('home.register',compact('rdata'));
        }else{
            $rdata = [
                'status' => 0,
                'msg' => '注册失败，请稍后重试!'
            ];
            $rdata = json_encode($rdata);
            return view('home.register',compact('rdata'));
        }

    }



}
