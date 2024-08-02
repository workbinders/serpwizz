<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
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
            'first_name' => 'string|min:3',
            'last_name'  => 'string|min:3',
            'email'      => 'string|email|' . Rule::unique(User::TABLE_NAME, User::EMAIL)->ignore($this->id),
            'password'   => 'string|min:8',
            'profile_image'=> 'image|mimes:jpeg,png,jpg|max:2048' //2mb image minimum
        ];
    }
}
