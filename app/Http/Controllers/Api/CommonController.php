<?php

namespace App\Http\Controllers\Api;

use Mail;
use App\Mail\NewUser;
use App\Mail\Test;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Requests\EmailRequest;
use Illuminate\Support\Facades\Redis;

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
        
        if ($this->is_robot($user->id, 60))
            return $this->message('操作太频繁，稍后再试');

        // 验证码
        $user->captcha = $this->generate_captcha();
        Redis::set('captcha:'.$user->id, $user->captcha);
        Redis::set('captchaTime:'.$user->id, time());

        $this->update_robot_time($user->id);

        Mail::to($user)->send(new NewUser($user));
        return $this->message('邮件发送成功');
    }

    // 校验验证码,设置新密码
    public function check_captcha(EmailRequest $request){
        $user = User::whereEmail($request->email)->first();
        $RedisCap = Redis::get('captcha:'.$user['id']);
        $captcha = $request->get('captcha');

        if (!$RedisCap) 
            return $this->message('请先获取验证码');
        // 验证码是否过期
        if ($this->isTimeout($user->id))
            return $this->message('验证码已经过期，请重新获取');
        if ($captcha != $RedisCap)
            return $this->message('验证码不正确');

        $user->update(['password' => $request->password]);
        Redis::del('captcha:'.$user['id']);
        return $this->message('新密码设置成功');
    }

    // 检查是否机器人
    public function is_robot($id, $time = 10){
        // 如果没有last_action_time说明接口没被调用过
        $lastActionTime = Redis::get('lastActionTime:'.$id);
        if (!$lastActionTime)
            return false;

        $elapsed = time() - $lastActionTime;
        return !($elapsed > $time);
    }

    // 上一次操作时间
    public function update_robot_time($id){
        Redis::set('lastActionTime:'.$id, time());
    }
    
    // 验证码是否过期
    public function isTimeout($id, $time=300){
        $captchaTime = Redis::get('captchaTime:'.$id);
        $elapsed = time() - $captchaTime;
        return ($elapsed > $time);
    }

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