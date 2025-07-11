<?php

namespace App\Exceptions;

use Throwable; // Use Throwable for exception handling
use Illuminate\Contracts\Debug\ExceptionHandler as BaseExceptionHandler;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler; // Correct import for ExceptionHandler

class Handler extends ExceptionHandler implements BaseExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        // Add exception classes you don't want to report, e.g.,
        // \Illuminate\Auth\AuthenticationException::class,
        // \Illuminate\Validation\ValidationException::class,
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
     * Report or log an exception.
     *
     * @param  \Throwable  $exception
     * @return void
     */
    public function report(Throwable $exception)
    {
        // Add custom logic for reporting exceptions if needed
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $exception
     * @return \Illuminate\Http\Response|\Symfony\Component\HttpFoundation\Response
     */
    public function render($request, Throwable $exception)
    {
        // Add custom logic for rendering exceptions if needed
        return parent::render($request, $exception);
    }
}
