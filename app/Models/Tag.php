<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    // 接受的字段
    protected $fillable = [
        'tag', 'classify'
    ];

    protected $hidden = [
        'updated_at'
    ];
    
    // 数据填充时自动忽略这个字段
    public $timestamps = false;

    public function article() {
        return $this->belongsTo('App\Models\article');
    }
}
