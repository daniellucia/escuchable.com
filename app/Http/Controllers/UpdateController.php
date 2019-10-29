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

        $shows = Shows::whereDate('updated_at', '<', Carbon::today()->toDateString())->orWhereNull('updated_at')->limit(15)->get();
        if (!$shows) {
            return 'Nada que actualizar';
        }

        $salida = [];

        foreach ($shows as $show) {
            /**
             * Actualziamos la fecha
             * de actualziación
             */

            $show->touch();

            /**
             * Leemos feed
             */
            $xml = null;
            try {
                $xml = Read::xml($show->feed);
            } catch (Exception $e) {
                continue;
            }

            /**
             * Actualizamos el título
             * del show
             */
            $show->updateByChannel($xml->channel);

            /**
             * Guardamos los episodios
             * correspondientes
             */
            Episodes::saveFromChannel($show, $xml->channel);

            $salida[] = $show->name;
        }

        return $salida;
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

    /**
     * Método para encontrar duplicados
     *
     * @return array
     */
    public function findDuplicates()
    {
        $shows = Shows::all();
        $showsUnique = $shows->unique('name');
        $results = $shows->diff($showsUnique);
        foreach ($results as $show) {
            Episodes::whereShow($show->id)->delete();
            $show->delete();
            echo $show->id . "\n";
        }
        return false;
    }
}
