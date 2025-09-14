<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class AllowAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return JsonResponse|Response|RedirectResponse|BinaryFileResponse
     */
    public function handle(Request $request, Closure $next): JsonResponse|Response|RedirectResponse|BinaryFileResponse
    {
        if (!Auth::user()->isAdmin()) {
            return redirect()->route('dashboard');
        }

        return $next($request);
    }
}
