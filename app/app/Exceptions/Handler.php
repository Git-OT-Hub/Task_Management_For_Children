<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\HttpException;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
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
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    protected function unauthenticated($request, Throwable $exception)
    {
        if ($request->expectsJson()) {
            return respomse()->json(['message' => $exception->getMessage()], 401);
        }

        if ($request->is('admin') || $request->is('admin/*')) {
            return redirect()->guest('/admin/login');
        }
        
        return redirect()->guest($exception->redirectTo ?? route('login'));
    }

    public function render($request, Throwable $exception)
    {
        // 403 This action is unauthorized
        if ($exception instanceof AuthorizationException) {
            return $this->redirectBasedOnUserType();
        }

        // 404 Not Found
        if ($exception instanceof NotFoundHttpException || $exception instanceof ModelNotFoundException) {
            return $this->redirectBasedOnUserType();
        }

        // その他のエラー
        return parent::render($request, $exception);
    }

    protected function redirectBasedOnUserType()
    {
        if (auth('admin')->check()) {

            return redirect('/admin/home');
        } elseif (auth()->check()) {

            return redirect('/');
        }

        return redirect('/');
    }
}
