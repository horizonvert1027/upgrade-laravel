<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Exception;
use Throwable;
use Request;
use Log;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Throwable  $exception
     * @return void
     *
     * @throws \Exception
     */
    public function report(Exception $e)
    {

        Log::info($e->getMessage(),
            [

                'url' => Request::url(),
                'all' => getallheaders(),
                'Referer' => Request::server('HTTP_REFERER')
                // 'IP'    => $_SERVER["HTTP_X_REAL_IP"],
                // 'HTTP_USER_AGENT' => $_SERVER['HTTP_USER_AGENT']
            ]);
        $error = 
        [
            'url' => Request::url(),
            'all' => getallheaders(), 
            'Referer' => Request::server('HTTP_REFERER')
        ];

         $message = $error['url'] . "\n" . json_encode($error, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
                \Log::info($message);
        return parent::report($e);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $exception)
    {
        return parent::render($request, $exception);
    }
}
