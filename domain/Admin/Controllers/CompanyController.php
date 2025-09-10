<?php

namespace Domain\Admin\Controllers;

use App\Http\Controllers\Controller;
use Domain\Admin\Requests\AdminRequest;
use Domain\Admin\Requests\CompanyDestroyRequest;
use Domain\Admin\Requests\CompanyUpdateRequest;
use Domain\Company\Enums\CountryCodeType;
use Domain\Company\Enums\SubscriptionType;
use Domain\Company\Models\Company;
use Domain\Company\Services\CompanyService;
use Domain\Helper\Enums\FlashMessageType;
use Domain\Helper\Enums\FlashType;
use Domain\Helper\Services\FlashMessageService;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class CompanyController extends Controller
{
    public function show(AdminRequest $request, Company $company): Response
    {
        $company->load([
            'locations',
            'quotations' => function ($query) {
                return $query->paginate(3);
            },
            'quotations.lines',
            'quotations.user',
            'orders' => function ($query) {
                return $query->paginate(3);
            },
            'orders.lines',
            'creditTransactions' => function ($query) {
                return $query->paginate(3);
            },
            'users',
            'comments',
            'comments.user',
        ]);

        $company->append('order_total_value');

        $creditTransactionCount = $company->creditTransactions()->count();
        $quotationCount = $company->quotations()->count();
        $orderCount = $company->orders()->count();

        return Inertia::render('Admin/Company/Show', [
            'company' => $company,
            'quotationCount' => $quotationCount,
            'orderCount' => $orderCount,
            'creditTransactionCount' => $creditTransactionCount,
        ]);
    }

    public function edit(AdminRequest $request, Company $company): Response
    {
        $subscriptionTypes = SubscriptionType::convertToDropdownList(true);
        $countryCodeTypes = CountryCodeType::convertToDropdownList(true);

        return Inertia::render('Admin/Company/Edit', [
            'subscriptionTypes' => $subscriptionTypes,
            'countryCodeTypes' => $countryCodeTypes,
            'company' => $company,
        ]);
    }

    public function update(CompanyUpdateRequest $request, Company $company): RedirectResponse
    {
        $validated = (object)$request->validated();

        $company = CompanyService::update($company, $validated);

        $company->exact_id = $validated->exact_id;
        $company->subscription_type = $validated->subscription_type;
        $company->save();

        return redirect()
            ->route('admin.company.show', $company)
            ->with(
                FlashMessageService::type(),
                FlashMessageService::sendSuccess(FlashMessageType::COMPANY_UPDATED),
            );
    }

    public function destroy(CompanyDestroyRequest $request, Company $company): RedirectResponse
    {
        $route = 'admin.' . $company->company_type->value . '.index';

        CompanyService::destroy($company);

        return redirect()
            ->route($route)
            ->with('message', [
                'type' => FlashType::SUCCESS,
                'value' => FlashMessageType::COMPANY_DELETED,
            ]);
    }
}
