<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\ElasticSearch\Repositories\ElasticSearchCarRepository;

class addelasticindexcars extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'elasticsearchindexadd:cars';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add elasticsearch index cars';

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
     * @return void
     */
    public function handle(ElasticSearchCarRepository $elasticSearchCarRepository): void
    {
        $elasticSearchCarRepository->createIndexCars();
    }
}
