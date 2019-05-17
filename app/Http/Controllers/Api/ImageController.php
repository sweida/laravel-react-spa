<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\ImageRequest;


class ImageController extends Controller
{
    // 上传图片
    public function uplod(ImageRequest $request){
        $imageUrl = Storage::disk('upyun')->put('/', $request->file('image'));
        return $this->success(['url'=>$imageUrl]);
    }

    // 删除图片
    public function delete(ImageRequest $request){
        $status = Storage::disk('upyun')->delete($request->get('image'));
        if($status){
            return $this->success('图片删除成功！');
        }
        return $this->failed('图片删除失败！');
    }
}