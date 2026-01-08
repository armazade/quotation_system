<?php

namespace Domain\Product\Requests;

use Domain\Product\Gates\ProductGate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ProductShowRequest extends FormRequest
{
    public function authorize(): bool
    {
        return ProductGate::show(Auth::user(), $this->route('product'));
    }

    public function rules(): array
    {
        return [];
    }
}
