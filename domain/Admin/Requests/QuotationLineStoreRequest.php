<?php

namespace Domain\Admin\Requests;

use Domain\Order\Enums\LineType;
use Domain\Quotation\Gates\QuotationGate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Enum;

class QuotationLineStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        $quotation = $this->route('quotation');

        return QuotationGate::updateDraft(Auth::user(), $quotation);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        $rules = [];
        $rules['line_type'] = ['required', new Enum(LineType::class)];
        $rules['description'] = ['required', 'string', 'max:255'];
        $rules['quantity'] = ['required', 'numeric', 'min:1'];
        $rules['unit_price'] = ['required', 'numeric'];

        return $rules;
    }
}
