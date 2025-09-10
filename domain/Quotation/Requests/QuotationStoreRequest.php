<?php

namespace Domain\Quotation\Requests;

use Domain\Quotation\Dtos\QuotationStoreDto;
use Domain\Quotation\Gates\QuotationGate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class QuotationStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return QuotationGate::store(Auth::user());
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return QuotationStoreDto::rawRules();
    }
}
