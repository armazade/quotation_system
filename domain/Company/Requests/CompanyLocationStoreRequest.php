<?php

namespace Domain\Company\Requests;

use Domain\Company\Enums\CountryType;
use Domain\User\Gates\UserGate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Enum;

class CompanyLocationStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return UserGate::existsWithCompany(Auth::user());
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return static::getRules();
    }

    public static function getRules(): array
    {
        $rules = [];
        $rules['address_line_1'] = ['required', 'string', 'max:255'];
        $rules['address_line_2'] = ['nullable', 'string', 'max:255'];
        $rules['zip_code'] = ['required', 'string', 'max:255'];
        $rules['city'] = ['required', 'string', 'max:255'];
        $rules['country'] = ['required', new Enum(CountryType::class)];

        return $rules;
    }
}
