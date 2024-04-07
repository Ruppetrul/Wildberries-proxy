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
        $response = [];

        try {
            $searchs = Search::all();

            foreach ($searchs as $search) {
                $response[$search->text] = 'Error';
            }

            Product::removeALl();

            foreach ($searchs as $search) {
                /*Wilberries API is not stable, so need to make sure that the response is correct.
                When the response is not correct, the 'params' key is present.*/
                $i = 0;
                while ($i < 10) {
                    $result = $this->wildberriesService->search($search->text);
                    if (is_array($result) && !isset($result['params']) && !empty($result['data']['products'])) {
                        $response[$search->text] = 'Success';
                        break;
                    }
                    sleep(1);
                    $i++;
                }

                if ($response[$search->text] != 'Success') {
                    continue;
                }
                $this->handleData($result['data']['products'], $search->id);
            }
        } catch (\Exception $exception) {
            Log::error($exception->getMessage());
        }

        foreach ($response as $key => $value) {
            echo "For search `$key` result `$value`" . PHP_EOL;
        }
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
