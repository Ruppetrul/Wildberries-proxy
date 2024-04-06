<?php

use App\Http\Controllers\ApiController;
use Illuminate\Support\Facades\Route;

Route::get('/search/{text}', [ApiController::class, 'search']);
