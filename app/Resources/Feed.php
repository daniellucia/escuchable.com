<?php

namespace App\Resources;

use App\Resources\Channel;
use App\Resources\Read;
use App\Shows;
use Illuminate\Support\Facades\Auth;

class Feed
{

    public static function insert(string $feed)
    {
        $feed = trim($feed);
        $show = Shows::where('feed', $feed)->first();

        if (!$show) {
            $xml = null;
            try {
                $xml = Read::xml($feed);
            } catch (Exception $e) {
                return false;
            }

            if (is_object($xml)) {
                $channel = new Channel($xml->channel);
                $data = $channel->toArray();

                $show = Shows::where('name', $data['name'])->first();

                if (!$show) {
                    $data['categories_id'] = intval($data['categories_id']);

                    $data['feed'] = $feed;

                    if ($user = Auth::user()) {
                        $data['user_id'] = $user->id;
                    }
                    $show = Shows::create($data);

                    $show->updated_at = null;
                    return $show->save();
                }

            }

        }

        return false;
    }

}
