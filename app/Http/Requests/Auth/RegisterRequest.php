<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class RegisterRequest extends FormRequest
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
            'name'  => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'phone' => ['nullable', 'string', 'max:20'],
            'username' => ['required', 'string', 'min:3', 'max:30', 'unique:user_credentials,username', 'regex:/^[a-zA-Z0-9._@]+$/'],
            'password' => ['required', 'confirmed', Password::defaults()],
            'password_confirmation' => ['required', 'string', 'min:8'],
        ];
    }

    public function messages(): array
    {
        return [
            'username.unique' => 'This username is already taken. Please try another.',
            'username.regex' => 'Username can only contain letters, numbers, dots (.), underscores (_), and the @ symbol. Spaces are not allowed.',
            'email.unique' => 'This email is already registered. Please sign in instead.',
        ];
    }
}
