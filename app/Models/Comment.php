<?php

namespace App\Models;

use App\Commons\Traits\Date;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $guarded = [];
    protected $appends = ['ar_created_at', 'en_created_at'];
    use Date;
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
