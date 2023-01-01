<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
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
        $this->renderable(function (Exception $e, $request) {

            if($e instanceof \Illuminate\Database\QueryException) {
                return response()->json([
                    'error' => true,
                    'message' => $e->errorInfo[count($e->errorInfo) - 1]
                ], 422);
            }

            if(!$e instanceof \Illuminate\Validation\ValidationException && $e->getMessage() == '') {
                return response()->json([
                    'error' => true,
                    'message' => 'Something went wrong'
                ], 422);
            }

            //Error handling for all non validation Exceptions
            if(!$e instanceof \Illuminate\Validation\ValidationException && $e->getMessage() != '') {
                return response()->json([
                    'error' => true,
                    'message' => $e->getMessage()
                ], 422);
            }
        });

    }


}
