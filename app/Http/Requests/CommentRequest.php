<?php

namespace App\Http\Requests;


class CommentRequest extends FormRequest
{
    public function rules()
    {
        if (FormRequest::getPathInfo() == '/api/v1/comment/add'){
            return [
                'content' => ['required'],
                'article_id' => ['required', 'exists:articles,id,deleted_at,NULL'], // 忽略软删除的数据
                'user_id' => ['exists:users,id'],
            ];
        } else if (FormRequest::getPathInfo() == '/api/v1/comment/edit'){
            return [
                'id' => ['required', 'exists:comments,id'],
                'content' => ['required'],
            ];
        } else if (FormRequest::getPathInfo() == '/api/v1/comment/read'){
            return [
                'article_id' => ['required', 'exists:articles,id,deleted_at,NULL'],
            ];
        } else {
            return [
                'id' => ['required', 'exists:comments,id']
            ];
        }

    }

    public function messages()
    {
        return [
            'content.required' => '评论内容不能为空',
            'article_id.required' => '文章id不能为空',
            'article_id.exists' => '文章id不存在',
            'user_id.exists' => '用户id不存在',
            'user_id.required' => '用户id不能为空',
            'id.required' => 'id不能为空',
            'id.exists' => 'id不存在',
        ];
    }
}
