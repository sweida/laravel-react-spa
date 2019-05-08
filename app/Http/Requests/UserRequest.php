<?php

namespace App\Http\Requests;

class UserRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name' => ['required', 'max:16', 'unique:users,name'],
            'email' => ['required', 'unique:users,email'],
            'password' => ['required', 'max:32', 'min:6'],
            'phone' => ['unique:users,phone']
        ];
    }

    public function messages()
    {
        return [
            'name.required'=>'用户名不能为空',
            'name.max' => '用户名长度不能超过16个字符',
            'name.unique' => '用户名已经存在',
            'email.required' => '邮箱不能为空',
            'email.unique' => '邮箱已经存在',
            'phone.unique' => '手机号已存在',
            'password.required' => '密码不能为空',
            'password.max' => '密码长度不能超过32个字符',
            'password.min' => '密码长度不能少于6个字符', 
        ];
    }
}