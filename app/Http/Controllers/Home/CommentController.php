<?php

namespace App\Http\Controllers\Home;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Model\Comment;
use Validator;
use DB;
//use PHPMailerAutoload;
//require 'vendor/phpmailer/phpmailer/PHPMailerAutoload.php';

class CommentController extends Controller
{
    /**
    * 接收评论
    *
    */
    public function store($art_id){
    	//接收数据
    	$input = Input::except('_token');
    	//dd($input);
   		//在中间件中已经验证，直接入库
    	$input['art_id'] = $art_id;
    	$input['ip'] = ip2long($this->getRealIp());
    	$input['pubtime'] = time();
        // dd($input);
    	//入库
    	$id = Comment::insertGetId($input);

    	if($id){
            Comment::where('comment_id',$id)->update(['reply_to'=>$id]);
    		$msg = [
    			'status' => 1,
    			'msg' => '评论发送成功!'
    		];
    		return $msg;
    	}else{
    		$msg = [
    			'status' => 0,
    			'msg' => '评论发送失败，请稍后再试!'
    		];
    		return $msg;
    	}
    	
    }
    /**
	* getRealIp() 获取用户真实ip
	*
	*/

	public function getRealIp(){
		static $realip = null;
		if($realip != null){
			return $realip;
		}
		//获取真实ip
		if(getenv('REMOTE_ADDR')){
			$realip = getenv('REMOTE_ADDR');
		}else if(getenv('HTTP_CLIENT_IP')){
			$realip = getenv('HTTP_CLIENT_IP');
		}else if(getenv('HTTP_X_FORWARDED_FOR')){
			$realip = getenv('HTTP_X_FORWARDED_FOR');
		}
		return $realip;
	}
    /**
    * 后台评论页
    */
    public function index(){
        $coms = Comment::orderBy('pubtime','desc')->paginate(10);
        return view('admin.comment.index',compact('coms'));
    }

    /**
    * 删除评论
    */
    public function destroy($comment_id){
        $art_id = Comment::where('comment_id',$comment_id)->first()->art_id;
        $rs = Comment::where('comment_id',$comment_id)->delete();
        
        if($rs) {
            //评论数-1;
            DB::table('article')->where('art_id',$art_id)->decrement('art_comment');
            $msg = [
                'status' => 1,
                'msg' => '评论删除成功!'
            ];
        }else{
            $msg = [
                'status' => 0,
                'msg' => '评论删除失败!'
            ];
        }
        return $msg;
    }

    /**
    * sendSingleEmail() 发送一封邮件
    * @param string $receiver 接收者
    * @param string $receiverName 接受者的姓名 
    * @param string $body 发送的内容
    */
    public function sendSingleEmail($receiver,$body) {
        
    }

    /**
    * sendMoreEmail() 发送多个邮件
    * @param string $sender 发送者
    * @param string $receiver 接收者
    * @param string $body 发送的内容
    */
    public function sendMoreMail(){
        $mail = new PHPMailer;
        $body = file_get_contents('contents.html');
        $mail->isSMTP();
        $mail->Host = 'smtp.example.com';
        $mail->SMTPAuth = true;
        $mail->SMTPKeepAlive = true; // SMTP connection will not close after each email sent, reduces SMTP overhead
        $mail->Port = 25;
        $mail->Username = 'yourname@example.com';
        $mail->Password = 'yourpassword';
        $mail->setFrom('list@example.com', 'List manager');
        $mail->addReplyTo('list@example.com', 'List manager');
        $mail->Subject = "PHPMailer Simple database mailing list test";
        //Same body for all messages, so set this before the sending loop
        //If you generate a different body for each recipient (e.g. you're using a templating system),
        //set it inside the loop
        $mail->msgHTML($body);
        //msgHTML also sets AltBody, but if you want a custom one, set it afterwards
        $mail->AltBody = 'To view the message, please use an HTML compatible email viewer!';
        //Connect to the database and select the recipients from your mailing list that have not yet been sent to
        //You'll need to alter this to match your database
        $mysql = mysqli_connect('localhost', 'username', 'password');
        mysqli_select_db($mysql, 'mydb');
        $result = mysqli_query($mysql, 'SELECT full_name, email, photo FROM mailinglist WHERE sent = false');
        foreach ($result as $row) { //This iterator syntax only works in PHP 5.4+
            $mail->addAddress($row['email'], $row['full_name']);
            if (!empty($row['photo'])) {
                $mail->addStringAttachment($row['photo'], 'YourPhoto.jpg'); //Assumes the image data is stored in the DB
            }
            if (!$mail->send()) {
                echo "Mailer Error (" . str_replace("@", "&#64;", $row["email"]) . ') ' . $mail->ErrorInfo . '<br />';
                break; //Abandon sending
            } else {
                echo "Message sent to :" . $row['full_name'] . ' (' . str_replace("@", "&#64;", $row['email']) . ')<br />';
                //Mark it as sent in the DB
                mysqli_query(
                    $mysql,
                    "UPDATE mailinglist SET sent = true WHERE email = '" .
                    mysqli_real_escape_string($mysql, $row['email']) . "'"
                );
            }
            // Clear all addresses and attachments for next loop
            $mail->clearAddresses();
            $mail->clearAttachments();
        }
    }



}
