<?php

namespace Domain\Admin\Controllers;

use App\Http\Controllers\Controller;
use Domain\Admin\Requests\QuotationAdminIndexRequest;
use Domain\Admin\Requests\QuotationDestroyRequest;
use Domain\Helper\Enums\FlashMessageType;
use Domain\Helper\Enums\FlashType;
use Domain\Helper\Services\FlashMessageService;
use Domain\Quotation\Enums\QuotationStatusType;
use Domain\Quotation\Models\Quotation;
use Domain\Quotation\Requests\QuotationShowRequest;
use Domain\Quotation\Services\QuotationService;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class QuotationController extends Controller
{
    public function index(QuotationAdminIndexRequest $request): Response
    {
        $validated = (object)$request->validated();

        $quotations = QuotationService::adminIndex(
            QuotationStatusType::tryFrom($validated->quotation_status ?? ''),
            $validated->reference ?? null,
            $validated->company_name ?? null,
            10,
        );

        return Inertia::render('Admin/Quotation/Index', [
            'quotations' => $quotations,
            'quotationStatusTypes' => QuotationStatusType::convertToDropdownList(true),
        ]);
    }

    public function show(QuotationShowRequest $request, Quotation $quotation): Response
    {
        $quotation->load([
            'company',
            'lines',
        ]);

        $render = Inertia::render('Admin/Quotation/Show', [
            'quotation' => $quotation,
        ]);

        if ($quotation->total_price <= 0) {
            $render->with('flash', [FlashMessageService::type() => FlashMessageService::sendError(FlashMessageType::QUOTATION_LOWER_THAN_ZERO)]);
        }

        return $render;
    }

    public function destroy(QuotationDestroyRequest $request, Quotation $quotation): RedirectResponse
    {
        QuotationService::destroy($quotation);

        return redirect()
            ->route('admin.quotation.index')
            ->with('message', [
                'type' => FlashType::SUCCESS,
                'value' => FlashMessageType::QUOTATION_DELETED,
            ]);
    }

}
