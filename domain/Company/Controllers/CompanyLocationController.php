<?php

namespace Domain\Company\Controllers;

use App\Http\Controllers\Controller;
use Domain\Admin\Requests\CompanyLocationUpdateRequest;
use Domain\Company\Enums\CountryType;
use Domain\Company\Models\Company;
use Domain\Company\Models\CompanyLocation;
use Domain\Company\Requests\CompanyLocationDestroyRequest;
use Domain\Company\Requests\CompanyLocationStoreRequest;
use Domain\Company\Services\CompanyLocationService;
use Domain\Helper\Enums\FlashMessageType;
use Domain\Helper\Enums\FlashType;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

class CompanyLocationController extends Controller
{
    public function store(CompanyLocationStoreRequest $request): RedirectResponse
    {
        $company = Company::where('id', Auth::user()->company_id)->first();

        $validated = (object)$request->validated();

        CompanyLocationService::store($company, $validated);

        return redirect()->route('client.company.show')
            ->with('message', [
                'type' => FlashType::SUCCESS,
                'value' => FlashMessageType::LOCATION_CREATED,
            ]);
    }

    public function create(Company $company): Response
    {
        $countryTypes = CountryType::convertToDropdownList(true);

        return Inertia::render('Client/Company/Location/Create', [
            'countryTypes' => $countryTypes,
            'company' => $company,
        ]);
    }

    public function edit(CompanyLocation $companyLocation): Response
    {
        $countryTypes = CountryType::convertToDropdownList(true);

        return Inertia::render('Client/Company/Location/Edit', [
            'countryTypes' => $countryTypes,
            'companyLocation' => $companyLocation,
        ]);
    }

    public function destroy(CompanyLocationDestroyRequest $request, CompanyLocation $companyLocation): RedirectResponse
    {
        CompanyLocationService::destroy($companyLocation);

        return redirect()->route('client.company.show')
            ->with('message', [
                'type' => FlashType::SUCCESS,
                'value' => FlashMessageType::LOCATION_DELETED,
            ]);
    }

    public function update(CompanyLocationUpdateRequest $request, CompanyLocation $companyLocation): RedirectResponse
    {
        $validated = (object)$request->validated();

        $companyLocation = CompanyLocationService::update($companyLocation, $validated);

        $company = Company::where('id', $companyLocation->company_id)->first();

        return redirect()
            ->route('client.company.show', $company)
            ->with('message', [
                'type' => FlashType::SUCCESS,
                'value' => FlashMessageType::LOCATION_UPDATED,
            ]);
    }
}
