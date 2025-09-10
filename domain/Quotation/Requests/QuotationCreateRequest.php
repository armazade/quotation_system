<?php

namespace Domain\Quotation\Requests;

use Domain\Quotation\Dtos\QuotationCreateDto;
use Illuminate\Foundation\Http\FormRequest;

class QuotationCreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return QuotationCreateDto::rawRules();
    }
}
