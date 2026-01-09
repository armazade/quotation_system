<?php

namespace App\Http\Middleware;

use Closure;
use Domain\Helper\Enums\LocaleType;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
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
        $locale = null;

        // First priority: authenticated user's locale preference
        if (Auth::check() && Auth::user()->locale_type) {
            $locale = Auth::user()->locale_type->value;
        }
        // Second priority: session locale
        elseif (Session::has('locale')) {
            $locale = Session::get('locale');
        }
        // Default: NL
        else {
            $locale = LocaleType::NL->value;
        }

        Session::put('locale', $locale);
        App::setLocale($locale);

        return $next($request);
    }
}
