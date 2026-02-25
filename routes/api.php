<?php

/**
 * This is NOT a freeware, use is subject to license terms.
 */

declare(strict_types=1);

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/**
 * RESTFul API version 1.
 *
 * Define the version of the interface that conforms to most of the
 * REST ful specification.
 */
Route::group(['prefix' => 'v1', 'as' => 'api.v1.'], function () {


    
});

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
