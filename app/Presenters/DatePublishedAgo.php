<?php

namespace App\Presenters;

trait DatePublishedAgo
{
    public function getPublishedAttribute($value)
    {
        return \Carbon\Carbon::createFromTimeStamp(strtotime($value))->diffForHumans();
    }
}
