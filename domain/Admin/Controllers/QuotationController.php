<?php

namespace Domain\Admin\Controllers;

use App\Http\Controllers\Controller;
use Domain\Admin\Requests\QuotationAdminIndexRequest;
use Domain\Admin\Requests\QuotationDestroyRequest;
use Domain\Quotation\Models\Quotation;
use Domain\Quotation\Services\QuotationService;
use Domain\Quotation\Requests\QuotationShowRequest;
use Domain\Quotation\Requests\QuotationStoreRequest;
use Domain\Quotation\Requests\QuotationUpdateRequest;
use Domain\Quotation\Enums\QuotationStatusType;
use Domain\Helper\Enums\FlashMessageType;
use Domain\Helper\Enums\FlashType;
use Domain\Helper\Services\FlashMessageService;
use Domain\Company\Models\Company;
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

    public function create(): Response
    {
        $companies = Company::orderBy('name')->get();

        return Inertia::render('Admin/Quotation/Create', [
            'companies' => $companies,
        ]);
    }

    public function store(QuotationStoreRequest $request): RedirectResponse
    {
        $validated = (object)$request->validated();

        $quotation = QuotationService::store($validated);

        return redirect()
            ->route('admin.quotation.show', $quotation)
            ->with('message', [
                'type' => FlashType::SUCCESS,
                'value' => FlashMessageType::QUOTATION_CREATED,
            ]);
    }

    public function show(QuotationShowRequest $request, Quotation $quotation): Response
    {
        $quotation->load([
            'company',
            'lines.product',
            'user',
        ]);

        return Inertia::render('Admin/Quotation/Show', [
            'quotation' => $quotation,
        ]);
    }

    public function edit(QuotationShowRequest $request, Quotation $quotation): Response
    {
        $companies = Company::orderBy('name')->get();

        return Inertia::render('Admin/Quotation/Edit', [
            'quotation' => $quotation,
            'companies' => $companies,
        ]);
    }

    public function update(QuotationUpdateRequest $request, Quotation $quotation): RedirectResponse
    {
        $validated = (object)$request->validated();

        $quotation = QuotationService::update($quotation, $validated);
        $quotation->save();

        return redirect()
            ->route('admin.quotation.show', $quotation)
            ->with('message', [
                'type' => FlashType::SUCCESS,
                'value' => FlashMessageType::QUOTATION_UPDATED,
            ]);
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

    public function send(Quotation $quotation): RedirectResponse
    {

        return redirect()
            ->route('admin.quotation.show', $quotation)
            ->with('message', [
                'type' => FlashType::SUCCESS,
                'value' => FlashMessageType::QUOTATION_CREATED,
            ]);
    }
}
