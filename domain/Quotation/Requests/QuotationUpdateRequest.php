<?php

namespace Domain\Quotation\Requests;

use Domain\User\Gates\UserGate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class QuotationUpdateRequest extends FormRequest
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
