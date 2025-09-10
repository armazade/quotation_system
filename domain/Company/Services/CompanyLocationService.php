<?php

namespace Domain\Company\Services;

use Domain\Company\Models\Company;
use Domain\Company\Models\CompanyLocation;

class CompanyLocationService
{
    public static function store(Company $company, object $data, bool $isDefault = false): CompanyLocation
    {
        $companyLocation = new CompanyLocation();
        $companyLocation->company_id = $company->id;
        $companyLocation->is_default = $isDefault;

        return static::update($companyLocation, $data, $isDefault);
    }

    public static function update(CompanyLocation $companyLocation, object $data, bool $isDefault = false): CompanyLocation
    {
        $companyLocation->address_line_1 = $data->address_line_1;
        $companyLocation->address_line_2 = $data->address_line_2;
        $companyLocation->zip_code = $data->zip_code;
        $companyLocation->city = $data->city;
        $companyLocation->country = $data->country;
        $companyLocation->save();

        return $companyLocation;
    }

    public static function destroy(CompanyLocation $location): void
    {
        $location->delete();
    }
}
