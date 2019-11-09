<?php

namespace App;

use App\Resources\Utils;
use Illuminate\Database\Eloquent\Model;

class Crawler extends Model
{
    protected $fillable = ['domain', 'url', 'date_revised'];

    public static function add($url)
    {
        $domain = Crawler::getDomain($url);

        self::create([
            'url' => $url,
            'domain' => $domain,
        ]);
    }

    public static function getDomain(string $url)
    {
        if (filter_var($url, FILTER_VALIDATE_URL)) {
            return str_replace('www.', '', parse_url($url)['host']);
        }

        return false;
    }

    public static function normalizeUrl($url) {
        $url = rtrim($url, '/');
        $url = strtok($url, '#');

        return $url;
    }
}
