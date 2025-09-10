<?php

namespace Domain\Helper\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function __invoke(Request $request)
    {
        return;
    }
}
