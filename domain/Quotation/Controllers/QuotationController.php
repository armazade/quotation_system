<?php

namespace Domain\Quotation\Controllers;

use App\Http\Controllers\Controller;
use Domain\Admin\Requests\QuotationDestroyRequest;
use Domain\Helper\Enums\FlashMessageType;
use Domain\Helper\Enums\FlashType;
use Domain\Helper\Enums\MimeExtensionType;
use Domain\Helper\Services\FlashMessageService;
use Domain\Order\Enums\CostType;
use Domain\Order\Enums\PaymentMethodType;
use Domain\Product\Enums\PmsColorCountType;
use Domain\Product\Enums\TransferType;
use Domain\Product\Models\Product;
use Domain\Product\Models\Transfer;
use Domain\Quotation\Dtos\QuotationStoreDto;
use Domain\Quotation\Enums\FileUploadType;
use Domain\Quotation\Models\Quotation;
use Domain\Quotation\Requests\QuotationIndexRequest;
use Domain\Quotation\Requests\QuotationShowRequest;
use Domain\Quotation\Requests\QuotationStoreRequest;
use Domain\Quotation\Services\PricingService;
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

//    public function create(QuotationCreateRequest $request): Response
//    {
//        $data = QuotationCreateDto::fromRequest($request);
//        $page = $data->page;
//
//        if ($page->value > QuotationPageType::TRANSFER_TYPE->value) {
//            $transferOptions = Transfer::query()
//                ->where('is_active', true)
//                ->whereHas('sizes')
//                ->whereHas('transfer', function ($query) use ($data) {
//                    $query->where('transfer_type', $data->transfer_type);
//                })
//                ->pluck('name', 'id');
//        }
//
//        $transfers = Transfer::query()
//            ->select(['id as identifier', 'description', 'info_link'])
//            ->where('is_active', true)
//            ->whereHas('sizes')
//            ->whereHas('transfer', function ($query) use ($data) {
//                $query->where('transfer_type', $data->transfer_type);
//            })->get();
//
//        if ($page->value > QuotationPageType::TRANSFER_ID->value) {
//            $sizeOptions = $data->transfer->setSizes()->pluck('size_type', 'id');
//        }
//
//        if ($page->value > QuotationPageType::TRANSFER_ID->value) {
//            $possibleBlocker = $data->transfer->transfer->has_blocker;
//            $possibleExpressDelivery = (bool)$data->transfer->delivery_time_express;
//        }
//
//        if ($page === QuotationPageType::PRICING) {
//            $pricing = PricingService::calculatePricing($data);
//
//            if (!$data->has_custom_size) {
//                $alternative = PricingService::alternativePricing($data, $pricing);
//            }
//        }
//
//        if (Auth::user()?->isAdmin()) {
//            if (!$data->company) {
//                $flash = [
//                    'message' => ['type' => FlashType::ERROR,
//                        'value' => FlashMessageType::ERROR_NO_COMPANY_SELECTED,
//                    ],
//                ];
//            } else {
//                $flash = [
//                    'message' => ['type' => FlashType::SUCCESS,
//                        'value' => trans('quotation_for', ['company_name' => $data->company->name]),
//                    ],
//                ];
//            }
//        }
//
//        return Inertia::render('Quotation/Create', [
//            'page' => $page,
//            'transferTypes' => TransferType::convertToDropdownList(),
//            'possibleBlocker' => $possibleBlocker,
//            'possibleExpressDelivery' => $possibleExpressDelivery,
//            'transfers' => $transfers ?? null,
//            'transferOptions' => $transferOptions ?? null,
//            'product' => $data->transfer ?? null,
//            'sizeTypes' => $sizeOptions ?? null,
//            'customSizeId' => isset($data->transfer) ? $data?->transfer?->customSizes?->first()?->id ?? null : null,
//            'deliveryOptions' => DeliveryType::convertToDropdownList(),
//            'processingTermOptions' => ProcessingTermType::convertToDropdownList(),
//            'booleanTypes' => BooleanType::convertToDropdownList(),
//            'pmsColorCountTypes' => PmsColorCountType::convertToDropdownList(),
//            'pricing' => $pricing ?? null,
//            'alternativePricingOptions' => $alternative ?? null,
//            'company' => $data->company ?? null,
//            'priceTechnicalDrawing' => CostType::TECHNICAL_DRAWING->value,
//        ])->with('flash', $flash ?? []);
//    }
}
