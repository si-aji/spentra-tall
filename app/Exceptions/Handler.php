<?php

namespace App\Exceptions;

use Illuminate\Auth\AuthenticationException;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<\Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<\Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    /**
     * Convert an authentication exception into a response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Auth\AuthenticationException  $exception
     * @return \Symfony\Component\HttpFoundation\Response
     */
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        \Log::debug("\App\Exceptions\Handler@unauthenticated ~ Debug on Unauthenticated function", [
            'request' => $request->all(),
            'message' => $exception->getMessage(),
            'route' => $request->route()->getName(),
        ]);

        $route = $exception->redirectTo() ?? route('login');
        if(str_contains($request->route()->getName(), 'adm') !== false){
            $route = route('adm.login');
        }
        
        return $this->shouldReturnJson($request, $exception)
                    ? response()->json(['message' => $exception->getMessage()], 401)
                    : redirect()->guest($route);
    }
}
