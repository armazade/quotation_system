<?php

namespace App\Http\Middleware;

use Closure;
use Domain\Helper\Enums\LocaleType;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class Localization
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure(Request): (Response|RedirectResponse) $next
     * @return Response|RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (Session::has('locale') && (App::getLocale() !== Session::get('locale'))) {
            App::setLocale(Session::get('locale'));
        } else {
            Session::put('locale', LocaleType::NL->value);
            App::setLocale(Session::get('locale'));
        }

        return $next($request);
    }
}
