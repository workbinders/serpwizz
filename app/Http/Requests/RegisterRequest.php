<?php

namespace App\Http\Requests;

use App\Models\User;
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
            User::FIRST_NAME   => 'required|string|min:3',
            User::LAST_NAME    => 'required|string|min:3',
            User::ACCOUNT_NAME => 'required|string|min:3|unique:users',
            User::EMAIL        => 'required|email|unique:users',
            User::PASSWORD     => [
                'required',
                Password::min(8)
                    ->numbers()
                    ->symbols()
                    ->mixedCase(),
            ],
        ];
    }
}
