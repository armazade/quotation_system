<?php

namespace Domain\Company\Requests;

use Domain\Company\Gates\CompanyLocationGate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class CompanyLocationDestroyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        $location = $this->route('companyLocation');

        return CompanyLocationGate::destroy(Auth::user(), $location);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [];
    }
}
