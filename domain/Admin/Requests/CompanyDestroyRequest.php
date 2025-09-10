<?php

namespace Domain\Admin\Requests;

use Domain\Company\Gates\CompanyGate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class CompanyDestroyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        $company = $this->route('company');

        return CompanyGate::destroy(Auth::user(), $company);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        $rules = [];

        return $rules;
    }
}
