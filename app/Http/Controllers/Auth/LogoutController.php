<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;

class LogoutController extends Controller
{
    public function __invoke(): RedirectResponse
    {
        Auth::logout();
        if(\Session::has('impersonate')){
            \Session::forget('impersonate');
        }

        return redirect(route('home'));
    }
}
