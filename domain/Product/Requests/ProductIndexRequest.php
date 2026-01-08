<?php

namespace Domain\Product\Requests;

use Domain\Product\Gates\ProductGate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ProductIndexRequest extends FormRequest
{
    public function authorize(): bool
    {
        return ProductGate::index(Auth::user());
    }

    public function rules(): array
    {
        return [];
    }
}
