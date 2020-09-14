<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

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
     * @throws \Throwable
     */
    public function report(Throwable $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $exception
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Throwable
     */
    public function render($request, Throwable $exception)
    {
        if ($exception instanceof QueryException) {
            return response()->json([
                'success'=>false,
                "result"=>[
                    "errorCode"=>-500,
                    "errorMsg"=>'Database Error'
                ]
            ], 500);
        }
    
        if ($exception instanceof NotFoundHttpException ) {
            return response()->json([
                'success'=>false,
                "result"=>[
                    "errorCode"=>-404,
                    "errorMsg"=>'Not found page'
                ]
            ], 404);
        }
    
        if ($exception instanceof MethodNotAllowedHttpException ) {
            return response()->json([
                'success'=>false,
                "result"=>[
                    "errorCode"=>-405,
                    "errorMsg"=>'Method not allowed.'
                ]
            ], 405);
        }
        if ($exception instanceof AuthenticationException ) {
            return response()->json([
                'success'=>false,
                "result"=>[
                    "errorCode"=>-401,
                    "errorMsg"=>'Unauthenticated.'
                ]
            ], 401);
            return parent::render($request, $exception);
        }

        return response()->json([
            'success'=>false,
                "result"=>[
                    "errorCode"=>-500,
                    "errorMsg"=>$exception->getMessage()
                ]
        ], 500);
    }
}
