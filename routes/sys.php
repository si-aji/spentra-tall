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
    // Dashboard
    Route::get('/', \App\Http\Livewire\Sys\Dashboard\Index::class)
        ->name('index');

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