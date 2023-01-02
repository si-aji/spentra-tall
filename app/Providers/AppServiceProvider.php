<?php

namespace App\Providers;

use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Collection::macro('paginate', function($perPage, $total = null, $page = null, $pageName = 'page') {
            $page = $page ?: LengthAwarePaginator::resolveCurrentPage($pageName);

            return new LengthAwarePaginator(
                $this->forPage($page, $perPage),
                $total ?: $this->count(),
                $perPage,
                $page,
                [
                    'path' => LengthAwarePaginator::resolveCurrentPath(),
                    'pageName' => $pageName,
                ]
            );
        });

        // Override TZ Session
        view()->composer('*', function ($view) 
        {
            if(\Auth::check() && get_class(\Auth::user()) === get_class((new \App\Models\User()))){
                if(!empty(\Auth::user()->getSpecificUserPreference('timezone'))){
                    $tz = \Auth::user()->getSpecificUserPreference('timezone');
                    if(!empty($tz)){
                        $tz = $tz->value;
                        $dtz = new \DateTimeZone($tz);
                        $utc = new \DateTime('now', $dtz);
                        $offset = $dtz->getOffset( $utc );
        
                        \Session::put('SAUSER_TZ', $tz);
                        \Session::put('SAUSER_TZ_OFFSET', (($offset / 60) * -1));
                    }
                }
            }

            $view;
        });
    }
}
