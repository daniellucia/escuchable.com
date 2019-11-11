<?php

namespace App\Presenters;

trait DatePublishedAgo
{
    public function getPublishedAttribute($value)
    {
        if ($value) {
            return \Carbon\Carbon::createFromTimeStamp(strtotime($value))->diffForHumans();
        }

        return '';
    }
}
