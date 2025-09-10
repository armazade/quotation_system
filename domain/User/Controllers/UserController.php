<?php

namespace Domain\User\Controllers;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Domain\Authentication\Requests\UserStoreRequest;
use Domain\Company\Enums\CompanyType;
use Domain\Company\Enums\CountryCodeType;
use Domain\Company\Enums\CountryType;
use Domain\Company\Enums\IndustryType;
use Domain\Company\Models\Company;
use Domain\Company\Services\CompanyLocationService;
use Domain\Product\Enums\BooleanType;
use Domain\User\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;
use Inertia\Response;

class UserController extends Controller
{
    public function store(UserStoreRequest $request): RedirectResponse
    {
        $validated = (object)$request->validated();

        $user = DB::transaction(function () use ($validated, $request) {
            $user = new User();
            $user->email = $validated->email;
            $user->first_name = $validated->first_name;
            $user->last_name = $validated->last_name;
            $user->locale_type = App::getLocale();
            $user->terms_accepted_at = now();
            $user->password = Hash::make($validated->password);
            $user->save();

            $company = new Company();
            $company->company_type = CompanyType::CLIENT;
            $company->name = $validated->company_name;
            $company->email = $validated->email;
            $company->phone_country_code = $validated->phone_country_code;
            $company->phone_number = $validated->phone_number;
            $company->website = clean_url($validated->website);
            $company->vat_number = $validated->vat_number;
            $company->coc_number = $validated->coc_number;
            $company->industry_type = $validated->industry_type;
            $company->save();

            CompanyLocationService::store($company, $request, true);

            $user->attachCompany($company);

            return $user;
        });

        event(new Registered($user));

        Auth::login($user);

        return redirect(RouteServiceProvider::HOME);
    }

    public function create(): Response
    {
        $countryTypes = CountryType::convertToDropdownList(true);
        $countryCodeTypes = CountryCodeType::convertToDropdownList(true);
        $industryTypes = IndustryType::convertToDropdownList(true);

        return Inertia::render('Auth/Register', [
            'countryTypes' => $countryTypes,
            'countryCodeTypes' => $countryCodeTypes,
            'industryTypes' => $industryTypes,
            'booleanTypes' => BooleanType::convertToDropdownList(),
        ]);
    }
}
