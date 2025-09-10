<?php

namespace Domain\Admin\Requests;

use Domain\User\Gates\UserGate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UserIndexRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return UserGate::isSuperAdmin(Auth::user());
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        $rules = [];
        $rules['full_name'] = ['nullable', 'string', 'max:255'];
        $rules['email'] = ['nullable', 'string', 'max:255'];
        $rules['company_name'] = ['nullable', 'string', 'max:255'];

        return $rules;
    }
}
