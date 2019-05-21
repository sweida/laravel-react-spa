<?php

namespace App\Http\Controllers\Api;

use Mail;
use App\Mail\NewUser;
use App\Mail\Test;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Requests\EmailRequest;

class CommonController extends Controller
{
    // 生成验证码
    public function generate_captcha()
    {
        return rand(1000, 9999);
    }

    // 发送邮件
    public function send_email(EmailRequest $request){
        $user = User::whereEmail($request->email)->first();
        // 验证码
        $user->captcha = $this->generate_captcha();

        Mail::to($user)->send(new NewUser($user));
        return $this->success('邮件发送成功');
    }

    // 校验验证码,设置新密码
    public function check_captcha(EmailRequest $request){
        $user = User::whereEmail($request->email)->first();
        $captcha = $request->get('captcha');

        if ($captcha != $user->captcha)
            return $this->failed('验证码不正确');

        $user->update(['password' => $request->password]);
        return $this->success('新密码设置成功');
    }

    // // 检查是否机器人
    // public function is_robot($time = 10)
    // {
    //     // 如果没有last_action_time说明接口没被调用过
    //     if (!session('last_action_time'))
    //         return false;

    //     $elapsed = time() - session('last_action_time');
    //     return !($elapsed > $time);
    // }

    // // 上一次操作时间
    // public function update_robot_time()
    // {
    //     session()->put('last_action_time', time());
    // }
    



    // // 用邮件验证码修改密码
    // public function email_valid(){
    //     if ($this->is_robot())
    //         return $this->success('操作太频繁');

    //     $this->update_robot_time();

    //     return ['time' => session('last_action_time')];
    // }

}


// public function send_email($email, $captcha)
// {
//     // Mail:raw发送纯text文本email
//     Mail::raw('验证码是'.$captcha.'，五分钟内有效', function($message) use($email) {
//         $message->subject('重置密码');
//         $message->to($email);
//     });

//     // Mail:send发送html模版email
//     Mail::send('mail.test', ['content' => $name], function ($message) use($to, $subject) { 
//         $message->to($to)->subject($subject); 
//     });
// }