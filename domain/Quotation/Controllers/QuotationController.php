<?php

namespace Domain\Quotation\Controllers;

use App\Http\Controllers\Controller;
use Domain\Admin\Requests\QuotationDestroyRequest;
use Domain\Company\Models\Company;
use Domain\Helper\Enums\FlashMessageType;
use Domain\Helper\Enums\FlashType;
use Domain\Helper\Services\FlashMessageService;
use Domain\Product\Enums\DeliveryType;
use Domain\Product\Models\Product;
use Domain\Quotation\Dtos\QuotationStoreDto;
use Domain\Quotation\Enums\FileUploadType;
use Domain\Quotation\Models\Quotation;
use Domain\Quotation\Requests\QuotationIndexRequest;
use Domain\Quotation\Requests\QuotationShowRequest;
use Domain\Quotation\Requests\QuotationStoreRequest;
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
            'lines',
        ]);

        $locations = Auth::user()->company->locations;

        $products = Product::query()
            ->where('is_active', true)
            ->inRandomOrder()
            ->get();

        $locationOptions = [];
        $locationOptions[] = '';
        $locationOptions = array_merge($locationOptions, $locations->pluck('address_line_1', 'id')->toArray());

        return Inertia::render('Client/Quotation/Show', [
            'quotation' => $quotation,
            'locations' => $locations,
            'products' => $products,
            'locationOptions' => $locationOptions,
            'fileUploadTypes' => FileUploadType::convertToDropdownList(),
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

    public function store(QuotationStoreRequest $request): RedirectResponse
    {
        $data = QuotationStoreDto::fromRequest($request);

        if (!$data->company) {
            return back()
                ->with('message', [
                    'type' => FlashType::ERROR,
                    'value' => FlashMessageType::ERROR,
                ]);
        }

        $quotation = QuotationService::store($data);

        if (Auth::user()->isAdmin()) {
            return redirect()
                ->route('admin.quotation.show', $quotation)
                ->with('message', [
                    'type' => FlashType::SUCCESS,
                    'value' => FlashMessageType::QUOTATION_CREATED,
                ]);
        }

        return redirect()
            ->route('client.quotation.show', $quotation)
            ->with('message', [
                'type' => FlashType::SUCCESS,
                'value' => FlashMessageType::QUOTATION_CREATED,
            ]);
    }

    public function create(QuotationCreateRequest $request): Response
    {
        $validated = $request->validated();

        // Get the product if product_id is provided
        $product = null;
        if (isset($validated['product_id'])) {
            $product = Product::with(['deliveryOptions', 'profileImages', 'supplier'])
                ->where('is_active', true)
                ->find($validated['product_id']);
        }

        // Get company for admin users
        $company = null;
        if (Auth::user()->isAdmin() && isset($validated['company_id'])) {
            $company = Company::find($validated['company_id']);
        } else {
            $company = Auth::user()->company;
        }

        // Get all active products for selection
        $products = Product::query()
            ->where('is_active', true)
            ->with(['deliveryOptions', 'profileImages', 'supplier'])
            ->get();

        // Set flash messages for admin users
        $flash = [];
        if (Auth::user()?->isAdmin()) {
            if (!$company) {
                $flash = [
                    'message' => [
                        'type' => FlashType::ERROR,
                        'value' => FlashMessageType::ERROR_NO_COMPANY_SELECTED,
                    ],
                ];
            } else {
                $flash = [
                    'message' => [
                        'type' => FlashType::SUCCESS,
                        'value' => trans('quotation_for', ['company_name' => $company->name]),
                    ],
                ];
            }
        }

        return Inertia::render('Quotation/Create', [
            'product' => $product,
            'products' => $products,
            'company' => $company,
            'deliveryOptions' => DeliveryType::convertToDropdownList(),
        ])->with('flash', $flash);
    }}
