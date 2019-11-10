<?php

namespace App\Presenters;

trait DateLastEpisodeAgo
{
    public function getLastEpisodeAttribute($value)
    {
        return \Carbon\Carbon::createFromTimeStamp(strtotime($value))->diffForHumans();
    }
}
