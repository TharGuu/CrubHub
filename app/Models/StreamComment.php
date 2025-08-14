<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StreamComment extends Model
{
    protected $fillable = ['body','user_id'];

    public function user() { return $this->belongsTo(User::class); }
}
