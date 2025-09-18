<?php

namespace Domain\Product\Requests;

use App\Rules\BooleanRule;
use Domain\User\Gates\UserGate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ProductUpdateRequest extends FormRequest
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
        $rules['name'] = ['required', 'string', 'max:255'];

        $rules['article_number'] = ['required', 'string', 'max:255', 'unique:products,article_number,' . $this->route('product')->id];

        $rules['unit_price'] = ['required', 'numeric', 'min:0'];
        $rules['is_active'] = ['required', new BooleanRule()];

        $rules['supplier_id'] = ['required', 'exists:companies,id'];
        $rules['notify_supplier'] = ['required', new BooleanRule()];

        $rules['file'] = ['nullable', 'file', 'max:50000', 'image'];

        return $rules;
    }
}
