<?php

namespace App\Widgets;

use App\Episodes;
use Arrilot\Widgets\AbstractWidget;
use Carbon\Carbon;

class RecentEpisodes extends AbstractWidget
{
    /**
     * The configuration array.
     *
     * @var array
     */
    protected $config = [
        'show' => false,
    ];

    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function run()
    {
        $show = intval($this->config['show']);
        if ($show > 0) {
            $episodesWidget = Episodes::actuals()->whereShowsId($show)->orderBy('published', 'desc')->limit(15)->get();
        } else {
            $episodesWidget = Episodes::actuals()->orderBy('published', 'desc')->limit(15)->get();
        }

        return view('widgets.recent_episodes', [
            'config' => $this->config,
            'episodesWidget' => $episodesWidget,
        ]);
    }
}
