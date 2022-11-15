<?php

namespace App\Commons\Traits;

use Carbon\Carbon;

trait Date
{
    public function getArCreatedAtAttribute()
    {
        Carbon::setLocale('ar');
        return (new Carbon($this->attributes["created_at"]))->diffForHumans();
    }
    public function getEnCreatedAtAttribute()
    {
        Carbon::setLocale('en');
        return (new Carbon($this->attributes["created_at"]))->diffForHumans();
    }
}
