<?php

namespace App\Http\Requests;

use Illuminate\Database\Query\Builder;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class LeadRequest extends FormRequest
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
            'website' => [
                'required',
                'url',
                Rule::unique('leads')->where(fn(Builder $query) => $query->where('user_id', $this->user_id))
            ],
            'first_name' => 'nullable|string|max:50',
            'last_name' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:50',
            'phone' => 'nullable|string|max:50',
            'customfield' => 'nullable|string|max:500',
            'checkbox' => 'nullable|string|max:50',
        ];
    }
}
