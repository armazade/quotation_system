<?php

namespace Domain\Quotation\Requests;

use Domain\Order\Enums\OrderStatusType;
use Domain\User\Gates\UserGate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class QuotationIndexRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return UserGate::isClient(Auth::user());
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

        return $rules;
    }
}
