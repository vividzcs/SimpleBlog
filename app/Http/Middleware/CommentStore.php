<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Input;
use DB;

class CommentStore
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $input = Input::except('_token');
        //dd($request->art_id);
        //验证数据
        if(isset($input['parent_id'])){
            if(!is_numeric($input['parent_id'])){
                $msg = [
                'status' => 0,
                'msg' => '文档加载出错!'
            ];
            return $msg;
            }
        }
        if(!preg_match('/^.{2,8}$/', $input['nick'])) {
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
        if(empty(trim($input['content']))){
            $msg = [
                'status' => 0,
                'msg' => '评论内容不能为空!'
            ];
            return $msg;
        }
        //验证通过，开始发邮件,有回复才发
        if(isset($input['reply_to'])) {
            //根据reply_to查询
            $receive = DB::table('comment')->where('reply_to',$input['reply_to'])->first();
            //dd($receive->email);
            $receiver = $receive->email;
            $receiverName = $receive->nick;
            $body = $input['content'] . '<br/><a href="ilearnspace.cn/a/' . $request->art_id . '">点击这里进入查看</a>';
            $mail = new \PHPMailer;   //生成一个PHPMailer对象
            $mail->isSMTP();   //用SMTP发送
            $mail->Host = 'smtp.qq.com';  //发送文件的服务器，邮件一般要先经过这个服务器
            $mail->SMTPAuth = true;
            $mail->SMTPKeepAlive = true; // SMTP connection will not close after each email sent, reduces SMTP overhead
            $mail->Port = 25;
            $mail->Username = '1747789689';
            $mail->Password = 'qqsktqgxihrqbhch';
            $mail->setFrom('1747789689@qq.com', '止戈的个人博客');
            $mail->addReplyTo('1747789689@qq.com', '止戈');
            $mail->Subject = "有人在止戈的个人博客上回复了你，快来看看吧!";
            //Same body for all messages, so set this before the sending loop
            //If you generate a different body for each recipient (e.g. you're using a templating system),
            //set it inside the loop
            $mail->msgHTML($body);
            //msgHTML also sets AltBody, but if you want a custom one, set it afterwards
            $mail->AltBody = '有人在止戈的个人博客上回复了你，快来看看吧!';
            //添加收件人的邮箱地址
            $mail->addAddress($receiver,$receiverName);
            $mail->addAddress('1747789689@qq.com','止戈');
        
            if (!$mail->send()) {
                $msg = [
                    'status' => 0,
                    'msg' => '评论失败，请稍后重试!或联系博主'
                ];
                return $msg;
            } else {
                //评论数+1
                DB::table('article')->where('art_id',$request->art_id)->increment('art_comment');
                // Clear all addresses for next loop
                $mail->clearAddresses();
                
            
            }
        }else{
            //发送给自己
            //dd($receive->email);
            $receiver = '1747789689@qq.com';
            $receiverName = '邓正成';
            $body = $input['content'] . '<br/><a href="http://www.ilearnspace.cn/a/' . $request->art_id . '">点击这里进入查看</a>';
            $mail = new \PHPMailer;   //生成一个PHPMailer对象
            $mail->isSMTP();   //用SMTP发送
            $mail->Host = 'smtp.qq.com';  //发送文件的服务器，邮件一般要先经过这个服务器
            $mail->SMTPAuth = true;
            $mail->SMTPKeepAlive = true; // SMTP connection will not close after each email sent, reduces SMTP overhead
            $mail->Port = 25;
            $mail->Username = '1747789689';
            $mail->Password = 'qqsktqgxihrqbhch';
            $mail->setFrom('1747789689@qq.com', '止戈的个人博客');
            $mail->addReplyTo('1747789689@qq.com', '止戈');
            $mail->Subject = "有人在止戈的个人博客上回复了你，快来看看吧!";
            //Same body for all messages, so set this before the sending loop
            //If you generate a different body for each recipient (e.g. you're using a templating system),
            //set it inside the loop
            $mail->msgHTML($body);
            //msgHTML also sets AltBody, but if you want a custom one, set it afterwards
            $mail->AltBody = '有人在止戈的个人博客上回复了你，快来看看吧!';
            //添加收件人的邮箱地址
            $mail->addAddress($receiver,$receiverName);
        
            if (!$mail->send()) {
                $msg = [
                    'status' => 0,
                    'msg' => '评论失败，请稍后重试!或联系博主'
                ];
                return $msg;
            } else {
                //评论数+1
                DB::table('article')->where('art_id',$request->art_id)->increment('art_comment');
                // Clear all addresses for next loop
                $mail->clearAddresses();
            }
        }
        return $next($request);
        
        
    }
}
