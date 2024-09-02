<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProfileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($this->user()->id)],
            'password' => ['nullable', 'min:8', 'confirmed'],
            'billing_address' => ['required', 'max:255'],
            'billing_city' => ['required', 'max:255'],
            'billing_state' => ['required', 'max:255'],
            'billing_country' => ['required', 'max:255'],
            'billing_zip_code' => ['required', 'max:20'],
        ];
    }
}
