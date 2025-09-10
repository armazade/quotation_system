<?php

namespace Domain\Admin\Requests;

use Domain\Quotation\Gates\QuotationGate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class QuotationDestroyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        $quotation = $this->route('quotation');

        return QuotationGate::exists(Auth::user(), $quotation);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [];
    }
}
