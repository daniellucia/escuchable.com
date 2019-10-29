<?php

namespace App\Resources;

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
}
