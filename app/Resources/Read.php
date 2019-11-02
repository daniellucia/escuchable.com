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

    public static function tags($string, $encoding = 'UTF-8')
    {
        $string = trim(strip_tags(html_entity_decode(urldecode($string))));
        if (empty($string)) {
            return false;
        }

        $extras = array(
            'p' => array('ante', 'bajo', 'con', 'contra', 'desde', 'durante', 'entre',
                'hacia', 'hasta', 'mediante', 'para', 'por', 'pro', 'segun',
                'sin', 'sobre', 'tras', 'via',
            ),
            'a' => array('los', 'las', 'una', 'unos', 'unas', 'este', 'estos', 'ese',
                'esos', 'aquel', 'aquellos', 'esta', 'estas', 'esa', 'esas',
                'aquella', 'aquellas', 'usted', 'nosotros', 'vosotros',
                'ustedes', 'nos', 'les', 'nuestro', 'nuestra', 'vuestro',
                'vuestra', 'mis', 'tus', 'sus', 'nuestros', 'nuestras',
                'vuestros', 'vuestras',
            ),
            'o' => array('esto', 'que'),
        );

        $string = mb_strtolower((string) $string, $encoding);
        $string = utf8_decode($string);
        $string = strtr($string,
            utf8_decode('âàåáäèéêëïîìíôöòóúûüùñ'),
            'aaaaaeeeeiiiioooouuuun'
        );
        if (preg_match_all('/\pL{3,}/s', $string, $m)) {
            $m = array_diff(array_unique($m[0]), $extras['p'], $extras['a'], $extras['o']);
        }
        return $m;
    }
}
