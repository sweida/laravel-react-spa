<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    public function article() {
        return $this->belongsTo('App\Models\article');
    }
}
