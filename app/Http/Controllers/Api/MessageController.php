<?php

namespace App\Http\Controllers\Api;

use App\Models\Message;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Requests\MessageRequest;

class MessageController extends Controller
{
    // 添加留言, 回复留言
    public function add(MessageRequest $request){
        // 获取用户id
        $user = Auth::guard('api')->user();
        $array = $request->all();
        $array['user_id'] = $user['id'];

        Message::create($array);
        return $this->success('添加成功');
    }

    // 修改留言
    public function edit(MessageRequest $request){
        $message = Message::find($request->id);
        $user = Auth::guard('api')->user();

        if (!$message['user_id'] || ($user['id'] != $message['user_id']))
            return $this->failed('你没有权限修改');

        $message->content = $request->get('content');
        return $message->save() ? 
            $this->success('留言修改成功') :
            $this->failed('留言修改失败');
    }

    // 删除留言
    public function delete(MessageRequest $request){
        $message = message::find($request->id);
        $user = Auth::guard('api')->user();

        if (!$message['user_id'] || ($user['id'] != $message['user_id']))
            return $this->failed('你没有权限删除');

        return $message->delete() ?
            $this->success('留言删除成功') :
            $this->failed('留言删除失败');
    }

    // 获取所有留言 分页
    public function list(){
        $messages = Message::with(['user'=>function($query){
                $query->select('id','name');
            }])
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        return $this->success($messages);
    }

    // 查看个人留言
    public function person(){
        $user = Auth::guard('api')->user();

        $messages = Message::where('user_id', $user['id'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        return $this->success($messages);
    }

}