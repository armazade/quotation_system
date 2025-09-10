<?php

namespace Domain\Admin\Requests;

use Domain\Quotation\Enums\QuotationStatusType;
use Domain\User\Gates\UserGate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Enum;

class QuotationAdminIndexRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return UserGate::isAdmin(Auth::user());
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        $rules = [];
        $rules['reference'] = ['nullable', 'string', 'max:255'];
        $rules['company_name'] = ['nullable', 'string', 'max:255'];
        $rules['quotation_status'] = ['nullable', new Enum(QuotationStatusType::class)];

        return $rules;
    }
}
