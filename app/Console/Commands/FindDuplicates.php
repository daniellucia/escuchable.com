<?php

namespace App\Console\Commands;

use App\Episodes;
use App\Shows;
use Illuminate\Console\Command;

class FindDuplicates extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update:duplicates';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Busca duplicados y los elimina';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $shows = Shows::all();

        $showsUnique = $shows->unique('name');
        $results = $shows->diff($showsUnique);
        $salida = [];

        if (empty($result)) {
            $this->info("Todo en orden");
            return;
        }

        $bar = $this->output->createProgressBar(count($results));
        $bar->start();

        foreach ($results as $show) {
            Episodes::whereShow($show->id)->delete();
            $show->delete();

            $salida[] = [
                'show' => $show->name,
            ];

            $bar->advance();

        }

        $this->table(['Show deleted'], $salida);
        $bar->finish();
    }
}
