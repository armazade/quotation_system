<?php

namespace Domain\Quotation\Requests;

use Domain\Quotation\Gates\QuotationGate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ClientQuotationStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return QuotationGate::store(Auth::user());
    }

    public function rules(): array
    {
        return [
            'reference' => ['nullable', 'string', 'max:255'],
            'lines' => ['required', 'array', 'min:1'],
            'lines.*.product_id' => ['required', 'exists:products,id'],
            'lines.*.quantity' => ['required', 'integer', 'min:1'],
            'lines.*.description' => ['required', 'string', 'max:255'],
            'lines.*.unit_price' => ['required', 'numeric', 'min:0'],
        ];
    }
}
