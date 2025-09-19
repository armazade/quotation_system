<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;
use Inertia\Inertia;

Route::get('/lang/{locale}', function (string $locale) {
    if (!in_array($locale, config('app.available_locales'))) {
        abort(400);
    }

    if (Auth::user()) {
        $user = Auth::user();
        $user->locale_type = $locale;
        $user->save();
    }

    session()->put('locale', $locale);
    app()->setLocale($locale);

    $previous = URL::previous();
    return Inertia::location($previous);
})->name('lang.update');
