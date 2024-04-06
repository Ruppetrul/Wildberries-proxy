<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;

class WildberriesService
{

    /**
     * @param $search
     * @return bool|string
     */
    public function search($search) {
        $response = null;
        try {
            $headers = [
                'Referer: https://www.wildberries.ru/catalog/0/search.aspx?search=' . urlencode($search),
            ];

            $queryParams = [
                'ab_testing'         => 'false',
                'appType'            => '1',
                'curr'               => 'rub',
                'dest'               => '-1257786',
                'query'              => $search,
                'resultset'          => 'catalog',
                'sort'               => 'popular',
                'spp'                => '30',
                'suppressSpellcheck' => 'false'
            ];

            $queryString = http_build_query($queryParams);
            $url = 'https://search.wb.ru/exactmatch/ru/common/v5/search' . '?' . $queryString;

            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

            $response = curl_exec($ch);

            $response = json_decode($response);

            curl_close($ch);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
        }

        return $response;
    }
}
