<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group([
    'as' => 'api.'
], function(){
    Route::group([
        'prefix' => 'sys',
        'as' => 'sys.',
        'middleware' => ['auth:web']
    ], function(){
        // Version
        Route::group([
            'prefix' => 'v0',
            'as' => 'v0.'
        ], function(){
            // Wallet List
            Route::get('wallet/group', [\App\Http\Controllers\Api\Sys\v0\WalletGroupController::class, 'list'])->name('wallet.group.list');
            Route::get('wallet', [\App\Http\Controllers\Api\Sys\v0\WalletController::class, 'list'])->name('wallet.list');

            // Category
            Route::get('category', [\App\Http\Controllers\Api\Sys\v0\CategoryController::class, 'list'])->name('category.list');

            // Tags
            Route::get('tag', [\App\Http\Controllers\Api\Sys\v0\TagController::class, 'list'])->name('tag.list');

            // Record
            Route::group([
                'prefix' => 'record',
                'as' => 'record.'
            ], function(){
                // Template
                Route::get('template', [\App\Http\Controllers\Api\Sys\v0\RecordTemplateController::class, 'list'])->name('template.list');
            });
        });
    });
});