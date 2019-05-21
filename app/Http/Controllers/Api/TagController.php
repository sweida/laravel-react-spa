<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TagController extends Controller
{
    public function read(){
        
        $articles = $this
            // ->orderBy('created_at', 'desc')
            ->with(['article'=>function($query){
                $query->select('id', 'title', 'img', 'clicks', 'created_at', 'classify');
                }])
            ->where('tag', rq('tag'))
            ->orderBy('article_id', 'desc')
            ->limit($limit)
            ->skip($skip)
            ->get(['article_id']);
    }
}
