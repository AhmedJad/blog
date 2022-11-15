<?php

namespace App\Models;

use App\Commons\Traits\Image;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use Image;
    protected $guarded = [];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
    protected $casts = [
        "created_at" => "date:d M Y"
    ];
}
