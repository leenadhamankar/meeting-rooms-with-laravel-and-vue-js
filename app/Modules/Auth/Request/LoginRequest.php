<?php

namespace App\Modules\Auth\Request;

use App\Http\Requests\Request;

class LoginRequest extends Request
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'email' => 'required|email:rfc,dns',
            'password' => 'required',
        ];
    }

    /**
     * Get custom attributes for validator errors.
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'email' => 'Email',
            'password' => 'Password',
        ];
    }

    public function throttleKey()
    {
        return strtolower($this->input('email')) . '|' . $this->ip(); // Track attempts by email & IP
    }

    public function resolveRequestSignature()
    {
        return $this->throttleKey();
    }
}
