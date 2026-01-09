<?php

namespace Domain\Admin\Controllers;

use App\Http\Controllers\Controller;
use Domain\Quotation\Models\Quotation;
use Domain\Quotation\Services\QuotationService;
use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller
{
    public function __invoke(): Response
    {
        $todayQuotationsCount = Quotation::whereDate('created_at', today())->count();
        $pendingQuotations = QuotationService::getPendingReview(6);

        return Inertia::render('Admin/Dashboard', [
            'todayQuotationsCount' => $todayQuotationsCount,
            'pendingQuotations' => $pendingQuotations,
        ]);
    }
}
