<?php

namespace App\Widgets;

use App\Episodes;
use Arrilot\Widgets\AbstractWidget;
use Illuminate\Support\Facades\Cache;

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
        $episodesWidget = Cache::remember(sprintf('episodes.%d', $show), 60, function () use ($show) {
            if ($show > 0) {
                return Episodes::whereShow($show)->orderBy('published', 'desc')->limit(15)->get();
            } else {
                return Episodes::orderBy('published', 'desc')->limit(15)->get();
            }

        });

        return view('widgets.recent_episodes', [
            'config' => $this->config,
            'episodesWidget' => $episodesWidget,
        ]);
    }
}
