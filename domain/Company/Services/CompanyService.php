<?php

namespace Domain\Company\Services;

use Domain\Company\Enums\CompanyType;
use Domain\Company\Models\Company;
use Domain\Quotation\Services\QuotationService;
use Domain\User\Services\UserService;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class CompanyService
{
    public static function adminIndex(?string $companyName = null, ?CompanyType $type = null, ?int $perPage = 10): LengthAwarePaginator
    {
        $query = Company::query()
            ->orderByDesc('created_at');

        if (isset($companyName)) {
            $query->where('name', 'like', '%'.$companyName.'%');
        }

        if (isset($type)) {
            $query->where('company_type', $type);
        }

        return $query->paginate($perPage)
            ->withQueryString();
    }

    public static function update(Company $company, object $data): Company
    {
        $company->name = $data->name;
        $company->email = $data->email;
        $company->phone_country_code = $data->phone_country_code;
        $company->phone_number = $data->phone_number;
        $company->website = $data->website;
        $company->legal_owner = $data->legal_owner;
        $company->vat_number = $data->vat_number;
        $company->coc_number = $data->coc_number;
        $company->iban_number = $data->iban_number;
        $company->bic_number = $data->bic_number;
        $company->debiteur_number = $data->debiteur_number ?? $company->debiteur_number;

        return $company;
    }

    public static function destroy(Company $company): void
    {
        DB::transaction(function () use ($company) {
            foreach ($company->quotations as $quotation) {
                QuotationService::destroy($quotation);
            }

            foreach ($company->locations as $location) {
                CompanyLocationService::destroy($location);
            }

            foreach ($company->users as $user) {
                UserService::destroy($user);
            }

            $company->delete();
        });
    }
}
