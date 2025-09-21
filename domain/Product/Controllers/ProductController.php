<?php

namespace Domain\Product\Controllers;

use App\Http\Controllers\Controller;
use Domain\Admin\Requests\AdminRequest;
use Domain\Company\Enums\CompanyType;
use Domain\Company\Models\Company;
use Domain\Helper\Enums\FlashMessageType;
use Domain\Helper\Enums\FlashType;
use Domain\Helper\Services\FlashMessageService;
use Domain\Product\Models\Product;
use Domain\Product\Requests\ProductStoreRequest;
use Domain\Product\Requests\ProductUpdateRequest;
use Domain\Product\Services\ProductService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ProductController extends Controller
{
    public function index(Request $request): Response
    {
        $products = Product::query()
            ->with('supplier')
            ->paginate(10);

        return Inertia::render('Admin/Product/Index', [
            'products' => $products,
        ]);
    }

    public function create(AdminRequest $request): Response
    {
        $suppliers = Company::query()
            ->where('company_type', CompanyType::SUPPLIER)
            ->orderBy('name')
            ->pluck('name', 'id');

        return Inertia::render('Admin/Product/Create', [
            'suppliers' => $suppliers,
        ]);
    }

    public function store(ProductStoreRequest $request): RedirectResponse
    {
        $validated = (object)$request->validated();

        $product = ProductService::update(new Product(), $validated);

        return redirect()
            ->route('admin.dashboard', $product)
            ->with(
                FlashMessageService::type(),
                FlashMessageService::sendSuccess(FlashMessageType::PRODUCT_CREATED)
            );
    }

    public function update(ProductUpdateRequest $request, Product $product): RedirectResponse
    {
        $validated = (object)$request->validated();

        $product = ProductService::update($product, $validated);

        return redirect()
            ->route('admin.dashboard', $product)
            ->with(
                FlashMessageService::type(),
                FlashMessageService::sendSuccess(FlashMessageType::PRODUCT_UPDATED)
            );
    }

    public function show(Request $request, Product $product): Response
    {
        return Inertia::render('Admin/Product/Show', [
            'product' => $product,
        ]);
    }

    public function edit(Product $product): Response
    {
        $suppliers = Company::query()
            ->where('company_type', CompanyType::SUPPLIER)
            ->orderBy('name')
            ->pluck('name', 'id');

        return Inertia::render('Admin/Product/Edit', [
            'product' => $product,
            'suppliers' => $suppliers,
        ]);
    }

    public function destroy(AdminRequest $request, Product $product): RedirectResponse
    {
        $product->media()->delete();
        $product->delete();

        return redirect()
            ->route('admin.product.index')
            ->with('message', [
                'type' => FlashType::SUCCESS,
                'value' => FlashMessageType::PRODUCT_DELETED,
            ]);
    }
}
