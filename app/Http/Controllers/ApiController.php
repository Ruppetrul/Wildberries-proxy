<?php

namespace App\Http\Controllers;

use App\Models\Search;
use Exception;

class ApiController extends Controller
{
    /**
     * @param $text
     * @return string
     */
    public function search($text)
    {
        try {
            $search = Search::where('text', urldecode($text))->with('products')->first();

            if (!$search) {
                throw new Exception('Searching with this value is not supported. '
                    . 'Try with a different value or configure the system for this query.', 404);
            }

            if ($search->products->isEmpty()) {
                throw new Exception('No products found for this search.', 404);
            }

            $products = $search->products->map(function ($product) {
                $product->data = json_decode($product->data);
                return $product->data;
            });
        } catch (\Exception $exception) {
            $errorCode = $exception->getCode();

            return response()->json([
                'success' => false,
                'message' => $exception->getMessage()
            ], $errorCode ?: 500);
        }

        return response()->json([
            'success' => true,
            'products' => $products
        ]);
    }
}
