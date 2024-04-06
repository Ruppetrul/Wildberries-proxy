<?php

use App\Http\Controllers\ApiController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;

Route::get('/search/{text}', [ApiController::class, 'search']);

Route::get('/updateData', function () {
    Artisan::call('app:update-search-data');
});
