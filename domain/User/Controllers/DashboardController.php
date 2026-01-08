<?php

namespace Domain\User\Controllers;

use App\Http\Controllers\Controller;
use Domain\Quotation\Models\Quotation;
use Domain\User\Enums\PermissionType;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ViewErrorBag;
use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller
{
    public function __invoke(): Application|RedirectResponse|Redirector|Response
    {
        if (Auth::user()->hasLoadedPermission(PermissionType::ADMIN_DASHBOARD)) {
            return redirect()->route('admin.dashboard')->with(['message' => session()->get('message', app(ViewErrorBag::class))]);
        }

        $quotations = Quotation::where('company_id', Auth::user()->company_id)
            ->with(['lines', 'lines.product'])
            ->orderByDesc('created_at')
            ->take(5)
            ->get();

        $quotationsCount = Quotation::where('company_id', Auth::user()->company_id)->count();

        return Inertia::render('Dashboard', [
            'quotations' => $quotations,
            'quotationsCount' => $quotationsCount,
        ]);
    }
}
