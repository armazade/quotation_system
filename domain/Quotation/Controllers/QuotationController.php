<?php

namespace Domain\Quotation\Controllers;

use App\Http\Controllers\Controller;
use Domain\Admin\Requests\QuotationDestroyRequest;
use Domain\Company\Models\Company;
use Domain\Helper\Enums\FlashMessageType;
use Domain\Helper\Enums\FlashType;
use Domain\Helper\Services\FlashMessageService;
use Domain\Product\Models\Product;
use Domain\Quotation\Models\Quotation;
use Domain\Quotation\Requests\ClientQuotationStoreRequest;
use Domain\Quotation\Requests\QuotationCreateRequest;
use Domain\Quotation\Requests\QuotationIndexRequest;
use Domain\Quotation\Requests\QuotationShowRequest;
use Domain\Quotation\Services\QuotationService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

class QuotationController extends Controller
{
    public function index(QuotationIndexRequest $request): Response
    {
        $validated = $request->validated();
        $companyId = Auth::user()->company_id;

        $quotations = QuotationService::index($companyId,
            $validated['reference'] ?? null,
            10
        );

        return Inertia::render('Client/Quotation/Index', [
            'quotations' => $quotations,
            'quotationTotal' => $quotations->count(),
        ]);
    }

    public function show(QuotationShowRequest $request, Quotation $quotation): Response
    {
        $quotation->load([
            'lines.product',
            'company',
        ]);

        return Inertia::render('Client/Quotation/Show', [
            'quotation' => $quotation,
        ]);
    }

    public function destroy(QuotationDestroyRequest $request, Quotation $quotation): RedirectResponse
    {
        QuotationService::destroy($quotation);

        return redirect()
            ->route('client.quotation.index')
            ->with(
                FlashMessageService::type(),
                FlashMessageService::sendSuccess(FlashMessageType::QUOTATION_DELETED)
            );
    }

    public function store(ClientQuotationStoreRequest $request): RedirectResponse
    {
        $validated = (object) $request->validated();
        $validated->company_id = Auth::user()->company_id;

        $quotation = QuotationService::storeWithLines($validated);

        return redirect()
            ->route('client.quotation.show', $quotation)
            ->with('message', [
                'type' => FlashType::SUCCESS,
                'value' => FlashMessageType::QUOTATION_CREATED,
            ]);
    }

    public function create(): Response
    {
        $products = Product::query()
            ->where('is_active', true)
            ->with(['profileImages', 'supplier'])
            ->get();

        $company = Auth::user()->company;

        return Inertia::render('Client/Quotation/Create', [
            'products' => $products,
            'company' => $company,
        ]);
    }
}
