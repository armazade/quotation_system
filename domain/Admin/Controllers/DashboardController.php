<?php

namespace Domain\Admin\Controllers;

use App\Http\Controllers\Controller;
use Domain\Quotation\Models\Quotation;
use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller
{
    public function __invoke(): Response
    {
        $todayQuotationsCount = Quotation::whereDate('created_at', today())->count();

        return Inertia::render('Admin/Dashboard', [
            'todayQuotationsCount' => $todayQuotationsCount,
        ]);
    }
}
