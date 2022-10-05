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
    'middleware' => ['web', 'auth']
], function(){
    // Dashboard
    Route::get('/', \App\Http\Livewire\Sys\Dashboard\Index::class)
        ->name('index');

    // Category
    Route::get('category', \App\Http\Livewire\Sys\Category\Index::class)
        ->name('category.index');

    // Wallet
    Route::group([
        'prefix' => 'wallet',
        'as' => 'wallet.'
    ], function(){
        // List
        Route::get('list', \App\Http\Livewire\Sys\Wallet\Lists\Index::class)
            ->name('list.index');
        // Group
        Route::get('group', \App\Http\Livewire\Sys\Wallet\Group\Index::class)
        ->name('group.index');
    });

    // Profile
    Route::get('profile', \App\Http\Livewire\Sys\Profile\Index::class)
        ->name('profile.index');
});