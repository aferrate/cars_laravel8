<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\ElasticSearch\Repositories\ElasticSearchCarRepository;

class deleteelasticindexcars extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'elasticsearchindexdelete:cars';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Delete elasticsearch index cars';

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
        $elasticSearchCarRepository->deleteIndexCars();
    }
}
