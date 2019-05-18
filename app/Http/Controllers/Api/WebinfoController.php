<?php

namespace App\Http\Controllers\Api;

use App\Models\Webinfo;
use Illuminate\Http\Request;

class WebinfoController extends Controller
{
    // 添加和修改信息
    public function set(Request $request){
        $webinfo = Webinfo::find(1); 
        if ($webinfo)
            $webinfo->update($request->all());
        else
            Webinfo::create($request->all());
        return $this->success('修改成功');
    }

    // 获取信息
    public function read(){
        $webinfo = Webinfo::findOrFail(1);
        return $this->success($webinfo);
    }

}
