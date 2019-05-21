<?php

namespace App\Http\Controllers\Api;


use App\Models\User;
use Hash;
use App\Http\Requests\UserRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;

// use App\Http\Resources\UserResource;

class UserController extends Controller
{
    //用户注册
    public function signup(UserRequest $request){
        User::create($request->all());
        return $this->success('用户注册成功');
    }

    //用户登录
    public function login(UserRequest $request){
        $token=Auth::guard('api')->attempt(
            ['name'=>$request->name,'password'=>$request->password]
        );
        if($token){
            return $this->success(['token' => 'bearer ' . $token]);
        }
        return $this->failed('密码有误！');
    }
    
    //用户退出
    public function logout(){
        Auth::guard('api')->logout();
        return $this->success('退出成功...');
    }

    //返回当前登录用户信息
    public function info(){
        $user = Auth::guard('api')->user();
        return $this->success($user);
    }

    //返回指定用户信息
    public function show(UserRequest $request){
        $user = User::find($request->id);
        return $this->success($user);
    }

    //返回用户列表 3个用户为一页
    public function list(){
        $users = User::paginate(10);
        // return UserResource::collection($users);
        return $this->success($users);
    }

    // 修改密码
    public function resetpassword(UserRequest $request){
        $user = Auth::guard('api')->user();
        $oldpassword = $request->get('oldpassword');

        if (!Hash::check($oldpassword, $user->password))
            return $this->failed('旧密码错误');

        $user->update(['password' => $request->password]);
        return $this->success('密码修改成功');
    }


}
