<?php

namespace App\Http\Controllers\Api;

use App\Models\Comment;
// use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Requests\CommentRequest;

class CommentController extends Controller
{
    // 添加评论, 回复评论
    public function add(CommentRequest $request){
        // 获取用户id
        $user = Auth::guard('api')->user();
        $array = $request->all();
        $array['user_id'] = $user['id'];

        Comment::create($array);
        return $this->success('添加成功');
    }

    public function common(Request $request, $text){
        $comment = Comment::find($request->id);
        $user = Auth::guard('api')->user();

        if (!$comment['user_id'] || ($user['id'] != $comment['user_id']))
            return $this->failed($text);
    }

    // 修改评论
    public function edit(CommentRequest $request){
        $comment = Comment::find($request->id);
        $user = Auth::guard('api')->user();

        if (!$comment['user_id'] || ($user['id'] != $comment['user_id']))
            return $this->failed('你没有权限修改');

        $comment->content = $request->get('content');
        return $comment->save() ? 
            $this->success('评论修改成功') :
            $this->failed('评论修改失败');
    }

    // 删除评论
    public function delete(CommentRequest $request){
        $comment = Comment::find($request->id);
        $user = Auth::guard('api')->user();

        if (!$comment['user_id'] || ($user['id'] != $comment['user_id']))
            return $this->failed('你没有权限删除');

        return $comment->delete() ?
            $this->success('评论删除成功') :
            $this->failed('评论删除失败');
    }

    // 获取所有评论 分页
    public function list(){
        $comments = Comment::with(['user'=>function($query){
                $query->select('id','name');
                }])
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        return $this->success($comments);
    }

    // 获取指定文章评论
    public function read(CommentRequest $request){
        // 关联模型写在model里
        $comments = Comment::with(['user'=>function($query){
                $query->select('id','name');
                }])
            ->where('article_id', $request->article_id)
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        return $this->success($comments);
    }

    // 查看个人评论
    public function person(){
        $user = Auth::guard('api')->user();

        $comments = Comment::where('user_id', $user['id'])
            ->orderBy('created_at', 'desc')
            ->paginate(10);
        return $this->success($comments);
    }

}
