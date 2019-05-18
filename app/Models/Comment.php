<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    // 接受的字段
    protected $fillable = [
        'content', 'article_id', 'user_id', 'name'
    ];

    // 表格隐藏的字段
    protected $hidden = [
        'updated_at'
    ];

    public function user() {
        return $this->belongsTo('App\Models\User');
    }

    public function article() {
        return $this->belongsTo('App\Models\article');
    }
}
