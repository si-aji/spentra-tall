<?php

use App\Http\Controllers\Auth\EmailVerificationController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Livewire\Auth\Login;
use App\Http\Livewire\Auth\Passwords\Confirm;
use App\Http\Livewire\Auth\Passwords\Email;
use App\Http\Livewire\Auth\Passwords\Reset;
use App\Http\Livewire\Auth\Register;
use App\Http\Livewire\Auth\Verify;
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
    'as' => 'adm.'
], function(){
    Route::middleware('guest:adm')->group(function () {
        Route::get('login', \App\Http\Livewire\Adm\Auth\Login::class)
            ->name('login');
    });

    // Admin Auth
    Route::group([
        'middleware' => ['impersonate:adm', 'auth:adm']
    ], function(){
        Route::post('logout', \App\Http\Controllers\Adm\Auth\LogoutController::class)
            ->name('logout');

        // Dashboard
        Route::get('/', function(){
            return redirect(route('adm.index'));
        });
        Route::get('dashboard', \App\Http\Livewire\Adm\Dashboard\Index::class)->name('index');

        // Log Viewer
        Route::get('log-viewer', \App\Http\Livewire\Adm\LogViewer\Index::class)->name('log-viewer.index');
    });
});