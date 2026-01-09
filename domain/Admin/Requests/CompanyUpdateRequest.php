<?php

namespace Domain\Admin\Requests;

use Domain\Company\Enums\CountryCodeType;
use Domain\Company\Enums\IndustryType;
use Domain\Company\Enums\SubscriptionType;
use Domain\Company\Gates\CompanyGate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Enum;

class CompanyUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return CompanyGate::adminUpdate(Auth::user());
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        $rules = [];
        $rules['name'] = ['required', 'string', 'max:255'];

        $rules['email'] = ['required', 'email', 'max:255'];
        $rules['phone_country_code'] = ['required', new Enum(CountryCodeType::class)];
        $rules['phone_number'] = ['required', 'numeric'];
        $rules['website'] = ['required', 'string', 'max:255'];

        $rules['coc_number'] = ['required', 'string', 'max:255'];
        $rules['vat_number'] = ['required', 'string', 'max:255'];

        $rules['legal_owner'] = ['nullable', 'string', 'max:255'];
        $rules['iban_number'] = ['nullable', 'string', 'max:255'];
        $rules['bic_number'] = ['nullable', 'string', 'max:255'];

        $rules['subscription_type'] = ['nullable', new Enum(SubscriptionType::class)];
        $rules['industry_type'] = ['nullable', new Enum(IndustryType::class)];

        $rules['exact_id'] = ['nullable', 'string', 'max:255'];
        $rules['debiteur_number'] = ['nullable', 'string', 'max:6', 'regex:/^\d{2}\.\d{3}$/', 'unique:companies,debiteur_number,'.$this->route('company')?->id];

        return $rules;
    }
}
