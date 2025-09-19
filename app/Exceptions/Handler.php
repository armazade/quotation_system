<?php

namespace App\Exceptions;

use App\Providers\RouteServiceProvider;
use Domain\Helper\Enums\FlashMessageType;
use Domain\Helper\Services\FlashMessageService;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Request;
use Psr\Log\LogLevel;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<Throwable>, LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
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
        $this->renderable(function (NotFoundHttpException $e, Request $request) {
            $route = RouteServiceProvider::HOME;

            return redirect(status: 404)
                ->to($route)
                ->with(
                    FlashMessageService::type(),
                    FlashMessageService::sendError(FlashMessageType::ERROR_NOT_FOUND)
                );
        });

        $this->renderable(function (AccessDeniedHttpException $e, Request $request) {
            $route = RouteServiceProvider::HOME;

            return redirect(status: 404)
                ->to($route)
                ->with(
                    FlashMessageService::type(),
                    FlashMessageService::sendError(FlashMessageType::ERROR_NO_PERMISSION)
                );
        });

        $this->reportable(function (Throwable $e) {
            if (app()->bound('sentry')) {
                app('sentry')->captureException($e);
            }
        });
    }
}
