<?php

namespace Domain\Company\Controllers;

use App\Http\Controllers\Controller;
use Domain\Company\Enums\CountryCodeType;
use Domain\Company\Models\Company;
use Domain\Company\Requests\CompanyShowRequest;
use Domain\Company\Requests\CompanyUpdateRequest;
use Domain\Company\Services\CompanyService;
use Domain\Helper\Enums\FlashMessageType;
use Domain\Helper\Enums\FlashType;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

class CompanyController extends Controller
{
    public function show(CompanyShowRequest $request, Company $company): Response
    {
        $company = Auth::user()->company;
        $company->load('locations');

        return Inertia::render('Client/Company/Show', [
            'company' => $company,
        ]);
    }

    public function edit(CompanyShowRequest $request): Response
    {
        $company = Auth::user()->company;
        $countryCodeTypes = CountryCodeType::convertToDropdownList(true);

        return Inertia::render('Client/Company/Edit', [
            'company' => $company,
            'countryCodeTypes' => $countryCodeTypes,
        ]);
    }

    public function update(CompanyUpdateRequest $request): RedirectResponse
    {
        $validated = (object)$request->validated();

        $company = Company::query()
            ->where('id', Auth::user()->company_id)
            ->first();

        $company = CompanyService::update($company, $validated);

        $company->save();

        return redirect()
            ->route('client.company.show')
            ->with('message', [
                'type' => FlashType::SUCCESS,
                'value' => FlashMessageType::COMPANY_UPDATED,
            ]);
    }
}
