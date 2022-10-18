<?php
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::group([
    'as' => 'sys.',
    'middleware' => ['web', 'auth:web']
], function(){
    // Manual
    Route::group([
        'prefix' => 'manual',
        'as' => 'manual.'
    ], function($q){
        Route::get('related-record', function(){
            $id = request()->has('id') ? request()->id : 1;
            $data = \App\Models\Record::findOrFail($id);

            return response()->json([
                'status' => true,
                'message' => 'Data Fetched',
                'result' => [
                    'data' => $data,
                    'related' => $data->getRelatedTransferRecord()
                ]
            ]);
        });
    });

    // Dashboard
    Route::get('/', \App\Http\Livewire\Sys\Dashboard\Index::class)
        ->name('index');

    // Record
    Route::group([
        'as' => 'record.',
        'prefix' => 'record'
    ], function(){
        // Template
        Route::get('template/{uuid}', \App\Http\Livewire\Sys\Record\Template\Show::class)
            ->name('template.show');
        Route::get('template', \App\Http\Livewire\Sys\Record\Template\Index::class)
            ->name('template.index');
    });
    Route::get('record/{uuid}', \App\Http\Livewire\Sys\Record\Show::class)
        ->name('record.show');
    Route::get('record', \App\Http\Livewire\Sys\Record\Index::class)
        ->name('record.index');

    // Wallet
    Route::group([
        'prefix' => 'wallet',
        'as' => 'wallet.'
    ], function(){
        // List
        Route::get('list/re-order', \App\Http\Livewire\Sys\Wallet\Lists\ReOrder::class)
            ->name('list.re-order');
        Route::get('list', \App\Http\Livewire\Sys\Wallet\Lists\Index::class)
            ->name('list.index');
        // Group
        Route::get('group/{uuid}', \App\Http\Livewire\Sys\Wallet\Group\Show::class)
        ->name('group.show');
        Route::get('group', \App\Http\Livewire\Sys\Wallet\Group\Index::class)
        ->name('group.index');
    });

    // Profile
    Route::get('profile', \App\Http\Livewire\Sys\Profile\Index::class)
        ->name('profile.index');
    // Category
    Route::get('category/re-order', \App\Http\Livewire\Sys\Profile\Category\ReOrder::class)
        ->name('category.re-order');
    Route::get('category', \App\Http\Livewire\Sys\Profile\Category\Index::class)
        ->name('category.index');
    // Tags
    Route::get('tag', \App\Http\Livewire\Sys\Profile\Tag\Index::class)
        ->name('tag.index');
});