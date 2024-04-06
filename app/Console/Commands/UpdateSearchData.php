<?php

namespace App\Console\Commands;

use App\Models\Product;
use App\Models\Search;
use App\Services\WildberriesService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

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
    protected $description = 'The basic process of updating data';

    public function __construct(WildberriesService $wildberriesService)
    {
        parent::__construct();
        $this->wildberriesService = $wildberriesService;
    }

    /**
     * @return void
     */
    public function handle()
    {
        $result = true;

        try {
            Product::removeALl();

            foreach (Search::all() as $search) {
                $result = $this->wildberriesService->search($search->text);

                if (!is_array($result) || empty($result['data']['products'])) {
                    //TODO Иногда тут может быть только 1 левая запись вместо вменяемого ответа.
                    continue;
                }
                $this->handleData($result['data']['products'], $search->id);
            }
        } catch (\Exception $exception) {
            $result = false;
            Log::error($exception->getMessage());
        }

        echo ($result ? 'Success' : 'Error') . PHP_EOL;
    }

    /**
     * @param array $data
     * @param int $search_id
     * @return void
     */
    private function handleData(array $data, int $search_id) {
        foreach ($data as $product) {
            if ($product['id']) {
                $newProduct = Product::updateOrCreate(
                    ['id' => $product['id']],
                    ['data' => json_encode($product)]
                );

                $newProduct->searches()->attach($search_id);
            }
        }
    }
}
