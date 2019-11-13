<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Jobs\ReviseUrlCrawler;

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

        /**
         * Añadimos la tarea a la cola
         */

        //ReviseUrlCrawler::dispatch($url);
    }

    public static function getDomain(string $url)
    {
        if (filter_var($url, FILTER_VALIDATE_URL)) {
            $parse = parse_url($url);

            if (isset($parse['host'])) {
                return str_replace('www.', '', $parse['host']);
            }

        }

        return false;
    }

    public static function normalizeUrl($url)
    {
        $url = rtrim($url, '/');
        $url = strtok($url, '#');

        return $url;
    }
}
