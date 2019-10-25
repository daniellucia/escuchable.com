<?php

namespace App\Http\Controllers;

use App\Episodes;
use App\Resources\Read;
use App\Shows;
use Carbon\Carbon;

class UpdateController extends Controller
{
    public function index()
    {
        /**
         * Obtenemos el siguiente show
         * para obtener el feed de episodios
         */

        $show = Shows::whereDate('updated_at', '<', Carbon::today()->toDateString())->orWhereNull('updated_at')->first();
        if (!$show) {
            return 'Nada que actualizar';
        }

        /**
         * Actualziamos la fecha
         * de actualziación
         */

        $show->touch();

        /**
         * Leemos feed
         */

        $xml = Read::xml($show->feed);

        /**
         * Actualizamos el título
         * del show
         */
        if (is_object($xml)) {
            $show->updateByChannel($xml->channel);
        }

        /**
         * Guardamos los episodios
         * correspondientes
         */
        if (is_object($xml)) {
            Episodes::saveFromChannel($show, $xml->channel);
        }

        return $show->name;
    }

    public function opml()
    {
        /**
         * Obtenemos el archivo opml local
         * para actualizarlo.
         * Este método puede ser usado para
         * que los usuarios puedan subir
         * sus propios opml
         */
        $xml = \File::get(storage_path('opml/Podcasts.opml'));
        Shows::saveFromOPML($xml);

        return [];
    }
}
