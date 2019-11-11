<?php

namespace App\Presenters;

trait DateLastEpisodeAgo
{
    public function getLastEpisodeAttribute($value)
    {
        if ($value) {
            return \Carbon\Carbon::createFromTimeStamp(strtotime($value))->diffForHumans();
        }

        return '';
    }
}
