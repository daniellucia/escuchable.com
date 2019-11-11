<?php

namespace App\Resources;

use App\Crawler;
use Goutte\Client;
use Illuminate\Support\Facades\Artisan;

class Read
{

    public static function xml(string $feed)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $feed);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_ENCODING, 'UTF-8');
        $data = curl_exec($ch);
        curl_close($ch);
        try {
            $xml = simplexml_load_string($data);
        } catch (\Exception $e) {
            $xml = false;
        }

        return $xml;
    }

    public static function tags(string $string): array
    {
        $string = trim(strip_tags(html_entity_decode(urldecode($string))));
        if (empty($string)) {
            return [];
        }
        $string = self::normalize($string);
        $string = str_replace(['?', '¿', '!', '¡', ':', '#', ',', '.', '«', '(', ')', '<', '>'], ' ', $string);
        $keywords = array_map(function ($string) {
            if (!is_numeric($string) && strlen($string) > 2) {
                return trim($string);
            }
        }, explode(' ', $string));

        if (empty($keywords)) {
            return [];
        }

        $stopwords = array_map(function ($string) {
            return trim($string);
        }, file(storage_path('opml/stopwords.txt')));

        return array_diff($keywords, $stopwords);
    }

    private static function normalize(string $string): string
    {
        $originals = 'ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûýýþÿŔŕ';
        $modifies = 'aaaaaaaceeeeiiiidnoooooouuuuybsaaaaaaaceeeeiiiidnoooooouuuyybyRr';
        $string = utf8_decode($string);
        $string = strtr($string, utf8_decode($originals), $modifies);
        $string = strtolower($string);
        return utf8_encode($string);
    }

    public static function links($element = false)
    {
        if (!$element) {
            return;
        }

        $client = new Client();
        $crawler = $client->request('GET', $element->url);
        $crawler->filter('a')->each(function ($node) use ($element) {
            $url = $node->attr('href');

            if (strlen($url) < 2) {
                return;
            }

            if (Crawler::getDomain($url) != $element->domain) {
                return;
            }

            Artisan::call('crawler:add', [
                'url' => $url,
            ]);
        });

        if ($crawler->filterXpath('//link[@type="application/rss+xml"]')->count() > 0) {
            $feed = $crawler->filterXpath('//link[@type="application/rss+xml"]')->attr('href');
            Feed::insert($feed);
        }

        if ($crawler->filterXpath('//a[@id="show_episodes_feed"]')->count() > 0) {
            $feed = $crawler->filterXpath('//a[@id="show_episodes_feed"]')->attr('href');
            Feed::insert($feed);
        }

        $element->date_revised = now();
        $element->save();
    }
}
