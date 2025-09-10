<?php

namespace Domain\Admin\Requests;

use Domain\Quotation\Gates\QuotationGate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class QuotationLineDestroyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        $quotationLine = $this->route('quotationLine');

        return QuotationGate::updateDraft(Auth::user(), $quotationLine->quotation);
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
