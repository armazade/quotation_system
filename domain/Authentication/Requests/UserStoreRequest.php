<?php

namespace Domain\Authentication\Requests;

use App\Rules\BooleanRule;
use Domain\Company\Enums\CountryCodeType;
use Domain\Company\Enums\IndustryType;
use Domain\Company\Requests\CompanyLocationStoreRequest;
use Domain\User\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Validation\Rules\Password;

class UserStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return !Auth::user();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        $rules = [];
        $rules['email'] = ['required', 'string', 'email', 'max:255', 'unique:' . User::class];
        $rules['first_name'] = ['required', 'string', 'max:255'];
        $rules['last_name'] = ['required', 'string', 'max:255'];
        $rules['password'] = ['required', 'confirmed', Password::defaults()];

        $rules['company_name'] = ['required', 'string', 'max:255'];
        $rules['industry_type'] = ['required', new Enum(IndustryType::class)];
        $rules['website'] = ['required', 'string', 'max:255'];

        $rules['phone_country_code'] = ['required', new Enum(CountryCodeType::class)];
        $rules['phone_number'] = ['required', 'numeric'];

        $rules['coc_number'] = ['required', 'string', 'max:255'];

        if (!$this->vat_number) {
            $rules['has_declared_coc'] = ['required', new BooleanRule(true)];
        } else {
            $rules['vat_number'] = ['required', 'string', 'max:255'];
        }

        $rules['terms_accepted'] = ['required', new BooleanRule(true)];

        return array_merge($rules, CompanyLocationStoreRequest::getRules());
    }
}
