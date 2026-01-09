<?php

namespace Domain\Quotation\Requests;

use Illuminate\Support\Facades\Auth;
use Domain\User\Gates\UserGate;
use Illuminate\Foundation\Http\FormRequest;

class QuotationStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return UserGate::isAdmin(Auth::user());
    }

    public function rules(): array
    {
        return [
            'company_id' => 'required|exists:companies,id',
        ];
    }
}
