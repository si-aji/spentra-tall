<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Impersonate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $url = preg_replace("(^https?://)", "", url()->current());
        // \Log::debug("Debug on Impersonate Middleware ~ \App\Http\Middleware\Impersonate@handle", [
        //     'url' => $url,
        //     'impersonate' => [
        //         'validation' => $request->session()->has('impersonate') ? 'TRUE' : 'FALSE',
        //         'value' => $request->session()->get('impersonate')
        //     ]
        // ]);

        if($request->session()->has('impersonate')){
            if(strpos($url, '/!') !== false){
                // Impersonate to Admin Dashboard
                $guard = 'adm';
                $user = \App\Models\Admin::where(\DB::raw('BINARY `uuid`'), $request->session()->get('impersonate'))
                    ->first();
                
                if(!empty($user)){
                    \Auth::guard($guard)->onceUsingId($user->id);
                }
            } else if(strpos($url, 'log-viewer') !== false){
                // Impersonate Admin Dashboard, to access Log Viewer
                $guard = 'adm';
                $user = \App\Models\Admin::where(\DB::raw('BINARY `uuid`'), $request->session()->get('impersonate'))
                    ->first();
                
                if(!empty($user)){
                    \Auth::guard($guard)->onceUsingId($user->id);
                }
            }
        }

        return $next($request);
    }
}
