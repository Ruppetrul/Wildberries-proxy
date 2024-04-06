<?php

namespace App\Console\Commands;

use App\Services\WildberriesService;
use Illuminate\Console\Command;

class UpdateSearchData extends Command
{
    /**
     * @var string
     */
    protected $signature = 'app:update-search-data';

    /**
     * @var null | WildberriesService
     */
    protected $wildberriesService = null;

    /**
     * @var string
     */
    protected $description = 'Command description';

    public function __construct(WildberriesService $wildberriesService)
    {
        parent::__construct();
        $this->wildberriesService = $wildberriesService;
    }

    public function handle()
    {
        $result = $this->wildberriesService->search('футболка оверсайз');
        dd($result);
    }
}
