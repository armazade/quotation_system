<?php

namespace Domain\Authentication\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function show(Request $request): RedirectResponse
    {
        return redirect()->route('login');
    }
}
